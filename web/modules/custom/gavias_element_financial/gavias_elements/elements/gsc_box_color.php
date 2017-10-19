<?php 
namespace Drupal\gavias_blockbuilder\shortcodes;
if(!class_exists('gsc_box_color')):
   class gsc_box_color{
      
      public function render_form(){
         $fields = array(
            'type'            => 'gsc_box_color',
            'title'           => t('Box color'),
            'size'            => 3,
            'icon'            => 'fa fa-bars',
            'fields' => array(
               array(
                  'id'        => 'title',
                  'type'      => 'textlangs',
                  'title'     => 'Title for box',
                  'class'     => 'display-admin'
               ),
               array(
                  'id'        => 'image',
                  'type'      => 'upload',
               ),
               array(
                  'id'        => 'content',
                  'type'      => 'textarealangs',
                  'title'     => t('Content for box'),
               ),
               array(
                  'id'        => 'link',
                  'type'      => 'textlangs',
                  'title'     => t('Link'),
               ),
               array(
                  'id'        => 'text_link',
                  'type'      => 'textlangs',
                  'title'     => t('Text Link'),
               ),
               array(
                  'id'        => 'color',
                  'type'      => 'text',
                  'title'     => t('Background color'),
                  'desc'      => t('Background color fox box. e.g: #ccc')
               ),
               array(
                  'id'        => 'target',
                  'type'      => 'select',
                  'title'     => t('Open in new window'),
                  'desc'      => t('Adds a target="_blank" attribute to the link'),
                  'options'   => array( 0 => 'No', 1 => 'Yes' ),
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
         return $fields;
      }

      public function render_content( $item ) {
         print self::sc_box_color( $item['fields'] );
      }

      public static function sc_box_color( $attr, $content = null ){
         global $base_url;
         extract(shortcode_atts(array(
            'image'                 => '',
            'title'                 => '',
            'content'               => '',
            'text_link'             => '',
            'link'                  => '',
            'text_link'             => 'Read more',
            'color'                 => '',
            'target'                => '',
            'el_class'              => '',
            'animate'               => ''
         ), $attr));

         if($image){
            $image = $base_url . '/' . $image; 
         }

         // target
         if( $target ){
            $target = 'target="_blank"';
         } else {
            $target = false;
         }

         if($animate){
            $el_class .= ' wow';
            $el_class .= ' ' . $animate;
         }

         $style_bg = '';
         if($color){
            $style_bg = "style=\"background-color: {$color};\"";
         }

         ?>
         <?php ob_start() ?>
         <div class="widget gsc-box-color clearfix <?php print $el_class; ?>">
            <?php if($image){ ?><div class="image"><img src="<?php print $image ?>" alt="<?php print strip_tags(gavias_render_textlangs($title)) ?>" /></div> <?php } ?>
            <div class="box-title" <?php print $style_bg ?>><?php print gavias_render_textlangs($title) ?></div>
            <div class="content" <?php print $style_bg ?>><?php print gavias_render_textarealangs($content) ?>
               <a class="link" <?php if(gavias_render_textlangs($link)) print 'href="'. gavias_render_textlangs($link) .'"' ?> <?php print $target ?>><?php print gavias_render_textlangs($text_link) ?></a>
            </div>
         </div>
         <?php return ob_get_clean() ?>
         <?php
      }

      public function load_shortcode(){
         add_shortcode( 'box_color', array('gsc_box_color', 'sc_box_color') );
      }
   }
endif;   




