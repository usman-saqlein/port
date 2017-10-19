<?php 
namespace Drupal\gavias_blockbuilder\shortcodes;
if(!class_exists('gsc_sliderlayer_block')):
   class gsc_sliderlayer_block{

      public function list_block_sliderlayer(){
         static $_blocks_array = array();
         if (empty($_blocks_array)) {
            // Get default theme for user.
            $theme_default = \Drupal::config('system.theme')->get('default');
            // Get storage handler of block.
            $block_storage = \Drupal::entityManager()->getStorage('block');
            // Get the enabled block in the default theme.
            $entity_ids = $block_storage->getQuery()->condition('theme', $theme_default)->execute();
            $entities = $block_storage->loadMultiple($entity_ids);
            $_blocks_array = [];
            foreach ($entities as $block_id => $block) {
               if(isset($block->get('settings')['provider']) && $block->get('settings')['provider'] == "gavias_sliderlayer"){
                  $_blocks_array[$block_id] = $block->label();
               }
            }
            asort($_blocks_array);
         }
         return $_blocks_array;
      }

      public function render_form(){
         $fields = array(
            'type' => 'gsc_sliderlayer_block',
            'title' => ('Sliderlayer Block'),
            'size' => 12,
            'fields' => array(
               array(
                  'id'        => 'title',
                  'type'      => 'text',
                  'title'     => t('Title display Admin'),
                  'class'     => 'display-admin'
               ),
               array(
                  'id'        => 'el_class',
                  'type'      => 'text',
                  'title'     => t('Extra class name'),
                  'desc'      => t('Style particular content element differently - add a class name and refer to it in custom CSS.'),
               ),
               array(
                  'id'        => 'animate',
                  'type'      => 'select',
                  'title'     => t('Animation'),
                  'desc'      => t('Entrance animation'),
                  'options'   => gavias_blockbuilder_animate(),
               ),
            ),                                      
         );
   
         $languages =  \Drupal::languageManager()->getLanguages();
         foreach ($languages as $language) { 
            $lid = $language->getId();
            $lname = $language->getName();
            $fields['fields'][] = array(
               'id'     => "info_${lname}",
               'type'   => 'info',
               'desc'   => "Block slider layer for {$lname} language"
            );
            $fields['fields'][] = array(
               'id'        => "block_drupal_{$lid}",
               'type'      => 'select',
               'title'     => t('Block sliderlayer'),
               'options'   => $this->list_block_sliderlayer(),
            );
         }
         return $fields;
      }

      public function render_content( $item ) {
         print self::sc_sliderlayer_block( $item['fields'] );
      }

      public function sc_sliderlayer_block( $attr, $content = null ){
          $default = array(
            'title'              => '',
            'el_class'           => '',
            'animate'            => ''
         );
         $languages =  \Drupal::languageManager()->getLanguages();
         foreach ($languages as $language) { 
            $lid = $language->getId();
            $default["block_drupal_{$lid}"] = '';
         }

         extract(shortcode_atts($default, $attr));

         $output = '';
         $class = array(); 
         $class[] = $el_class;
         if($animate){
            $class[] = 'wow';
            $class[] = $animate;
         }

         $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
         $block_name = "block_drupal_{$language}";
         if($$block_name){
            $output .= '<div class="widget gsc-block-drupal remove-margin-on gsc-sliderlayer-block margin-0 padding-0 '.implode($class, ' ') .'">';
              $output .= gavias_blockbuilder_render_block($$block_name);
            $output .= '</div>';
         } 
         return $output;  
      }

      public function load_shortcode(){
         add_shortcode( 'block', array($this, 'sc_sliderlayer_block' ));
      }
   }
endif;
   



