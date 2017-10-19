<?php 
namespace Drupal\gavias_blockbuilder\shortcodes;
if(!class_exists('gsc_box_number')):
   class gsc_box_number{
      public function render_form(){
         return array(
           'type'          => 'gsc_box_number',
            'title'        => t('Box number'),
            'size'         => 3,
            'fields' => array(
               array(
                  'id'        => 'title',
                  'type'      => 'textlangs',
                  'title'     => t('Title'),
                  'class'     => 'display-admin'
               ),
               array(
                  'id'        => 'content',
                  'type'      => 'textarealangs',
                  'title'     => t('Content'),
                  'desc'      => t('Content for box color'),
               ),
               array(
                  'id'        => 'color',
                  'type'      => 'text',
                  'title'     => t('Color for box'),
                  'desc'      => t('Use color name ( blue ) or hex ( #f5f5f5 )')
               ),
               array(
                  'id'        => 'number',
                  'type'      => 'text',
                  'title'     => t('Number'),
                  'desc'      => t('Number display, e.g: 1, 2'),
               ),
               array(
                  'id'        => 'link',
                  'type'      => 'textlangs',
                  'title'     => t('Link'),
               ),
               array(
                  'id'        => 'target',
                  'type'      => 'select',
                  'title'     => t('Open in new window'),
                  'desc'      => t('Adds a target="_blank" attribute to the link'),
                  'options'   => array( 'off' => 'No', 'on' => 'Yes' ),
                  'std'       => 'on'
               ),
               array(
                  'id'        => 'animate',
                  'type'      => 'select',
                  'title'     => t('Animation'),
                  'sub_desc'  => t('Entrance animation'),
                  'options'   => gavias_blockbuilder_animate(),
               ),
               array(
                  'id'        => 'el_class',
                  'type'      => 'text',
                  'title'     => t('Extra class name'),
                  'desc'      => t('Style particular content element differently - add a class name and refer to it in custom CSS.'),
               ),
            ),                                     
         );
      }

      public function render_content( $item ) {
         if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
            print self::sc_box_number( $item['fields'], $item['fields']['content'] );
      }

      public static function sc_box_number( $attr, $content = null ){
         global $base_url;
         extract(shortcode_atts(array(
            'title'              => '',
            'content'            => '',
            'color'              => '',
            'number'             => '',
            'link'               => '',
            'target'             => '',
            'animate'            => '',
            'el_class'           => ''
         ), $attr));

         // target
         if( $target ){
            $target = 'target="_blank"';
         } else {
            $target = false;
         }

         if($animate){
            $el_class .= ' wow';
            $el_class .= ' '. $animate;
         }
         
         $bg_color = '';
         $text_color = '';
         if($color){
            $bg_color = "style=\"background-color: {$color};\"";
            $text_color = "style=\"color: {$color}\"";
         }

         ?>
         <?php ob_start() ?>
         <div class="widget gsc-box-number <?php print $el_class ?>">
            <div class="content-inner text-center">
               <?php if($number){ ?>
                  <div class="number" <?php print $bg_color ?>><?php print $number; ?></div>
               <?php } ?>
               <div class="content">
                  <div class="title">
                     <?php if(gavias_render_textlangs($link)){ ?>
                        <a <?php print $target ?> href="<?php print gavias_render_textlangs($link) ?>" <?php print $text_color ?>><?php print gavias_render_textlangs($title) ?></a>
                     <?php }else{ ?>
                        <a <?php print $text_color ?>><?php print gavias_render_textlangs($title) ?></a>
                     <?php } ?>   
                  </div>   
                  <?php if(gavias_render_textarealangs($content)){ ?>
                     <div class="desc"><?php print gavias_render_textarealangs($content) ?></div>
                  <?php } ?>
               </div>
            </div>
         </div>
         <?php return ob_get_clean() ?>
      <?php
      } 

      public function load_shortcode(){
         add_shortcode( 'box_number', array($this, 'sc_box_number'));
      }
   }
endif;   
