<?php 
namespace Drupal\gavias_blockbuilder\shortcodes;
if(!class_exists('gsc_counter')):
   class gsc_counter{
      public function render_form(){
         $fields = array(
            'type' => 'gsc_counter',
            'title' => ('Counter'),
            'size' => 3,
            'fields' => array(
               array(
                  'id'        => 'title',
                  'title'     => t('Title'),
                  'type'      => 'textlangs',
                  'class'     => 'display-admin'
               ),
               array(
                  'id'        => 'icon',
                  'title'     => t('Icon'),
                  'type'      => 'text',
                  'std'       => '',
                  'desc'     => t('Use class icon font <a target="_blank" href="http://fontawesome.io/icons/">Icon Awesome</a>'),
               ),
               array(
                  'id'        => 'number',
                  'title'     => t('Number'),
                  'type'      => 'text',
               ),
               array(
                  'id'        => 'type',
                  'title'     => t('Style'),
                  'type'      => 'select',
                  'options'   => array(
                     'icon-left'     => 'Icon left',
                     'icon-top'   => 'Icon top',
                     'icon-top-v2'   => 'Icon top v2',
                     'icon-top-v3'   => 'Icon top v3',
                  ),
                  'std'    => 'icon-left',
               ),
               array(
                  'id'        => 'background',
                  'type'      => 'text',
                  'title'     => t('Background Box'),
                  'desc'      => t('Use color name ( blue ) or hex ( #2991D6 )'),
               ),
               array(
                  'id'        => 'style_text',
                  'type'      => 'select',
                  'title'     => t('Skin Text for box'),
                  'options'   => array(
                     'text-dark'   => 'Text dark',
                     'text-light'   => 'Text light'
                  ),
                  'std'       => 'text-dark'
               ),
               array(
                  'id'        => 'el_class',
                  'type'      => 'text',
                  'title'     => t('Extra class name'),
                  'desc'      => t('Style particular content element differently - add a class name and refer to it in custom CSS.'),
               ),
               array(
                  'id'     => 'animate',
                  'type'      => 'select',
                  'title'  => t('Animation'),
                  'sub_desc'  => t('Entrance animation'),
                  'options'   => gavias_blockbuilder_animate(),
               ),
         
            ),                                      
         );
         return $fields;
      }


      public function render_content( $item ) {
         print self::sc_counter( $item['fields'] );
      }


      public function sc_counter( $attr, $content = null ){
         extract(shortcode_atts(array(
            'title'         => '',
            'icon'          => '',
            'number'        => '',
            'type'          => 'vertical',
            'el_class'      => '',
            'style_text'    => 'text-light',
            'background'    => '',
            'animate'       => '',
         ), $attr));
         $class = array();
         $class[] = $el_class;
         $class[] = 'position-'.$type;
         $class[] = $style_text;
         if($animate){
            $class[] = 'wow';
            $class[] = $animate;
         }
         $style = '';
         if($background) $style = "background-color: {$background};";
         if($style) $style = 'style="'.$style.'"';
         ?>
         <?php ob_start() ?>
         <?php if($type == 'icon-top-v3'){ ?>

            <div class="widget milestone-block <?php if(count($class) > 0){ print implode($class, ' '); } ?>" <?php print $style ?>>
               <div class="milestone-number"><?php print $number; ?></div>
               <?php if($icon){ ?><div class="milestone-icon"><span class="<?php print $icon; ?>"></span></div><?php } ?>   
               <div class="milestone-text"><?php print gavias_render_textlangs($title) ?></div>
            </div>

         <?php }else{ ?>

            <div class="widget milestone-block <?php if(count($class) > 0){ print implode($class, ' '); } ?>" <?php print $style ?>>
               <?php if($icon){ ?>
                  <div class="milestone-icon"><span class="<?php print $icon; ?>"></span></div>
               <?php } ?>   
               <div class="milestone-right">
                  <div class="milestone-number"><?php print $number; ?></div>
                  <div class="milestone-text"><?php print gavias_render_textlangs($title) ?></div>
               </div>
            </div>

         <?php } ?>
            
         <?php return ob_get_clean() ?>
         <?php
      }

       public function load_shortcode(){
         add_shortcode( 'counter', array('gsc_counter', 'sc_counter' ));
       }
   }
endif;
   



