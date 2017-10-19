<?php 
namespace Drupal\gavias_blockbuilder\shortcodes;
if(!class_exists('gsc_box_text')):
   class gsc_box_text{
      public function render_form(){
         return array(
           'type'          => 'gsc_box_text',
            'title'        => t('Box Text'),
            'size'         => 3,
            'icon'         => 'fa fa-bars',
            'fields' => array(
               array(
                  'id'        => 'title',
                  'type'      => 'textlangs',
                  'title'     => t('Title'),
                  'class'     => 'display-admin'
               ),
               array(
                  'id'        => 'sub_title',
                  'type'      => 'textlangs',
                  'title'     => t('Sub Title'),
               ),
               array(
                  'id'        => 'content',
                  'type'      => 'textarealangs',
                  'title'     => t('Content'),
               ),
               array(
                  'id'        => 'background',
                  'type'      => 'text',
                  'title'     => t('Background Box'),
                  'desc'      => t('Use color name ( blue ) or hex ( #2991D6 )'),
               ),
                array(
                  'id'        => 'title_color',
                  'type'      => 'text',
                  'title'     => t('Color for title'),
                  'desc'      => t('Use color name ( blue ) or hex ( #2991D6 )'),
               ),
               array(
                  'id'        => 'link',
                  'type'      => 'textlangs',
                  'title'     => t('Link'),
               ),
               array(
                  'id'        => 'style',
                  'type'      => 'select',
                  'title'     => t('Style display'),
                  'options'   => array(
                        'style-1'         => 'Style v1',
                        'style-2'         => 'Style v2',
                        'style-3'         => 'Style v3',
                        'style-4'         => 'Style v4',
                  )
               ),
               array(
                  'id'        => 'target',
                  'type'      => 'select',
                  'title'     => t('Open in new window'),
                  'desc'      => t('Adds a target="_blank" attribute to the link'),
                  'options'   => array( 'off' => 'No', 'on' => 'Yes' ),
                  
               ),
               array(
                  'id'        => 'height',
                  'type'      => 'text',
                  'title'     => t('Min height for box'),
                   'desc'      => t('Setting min height for box, e.g: 200px')
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
      }

      public function render_content( $item ) {
         if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
            print self::sc_box_text( $item['fields'], $item['fields']['content'] );
      }

      public static function sc_box_text( $attr, $content = null ){
         global $base_url;
         extract(shortcode_atts(array(
            'title'              => '',
            'sub_title'          => '',
            'content'            => '',
            'background'         => '',
            'title_color'        => '',
            'link'               => '',
            'style'              => 'style-1',
            'target'             => '',
            'height'             => '',
            'el_class'           => '',
            'animate'            => ''
         ), $attr));

         // target
         if( $target ){
            $target = 'target="_blank"';
         } else {
            $target = false;
         }

         $style_css = '';
         if($background) $style_css = "background: {$background};";
         if($height) $style_css .= "min-height: {$height};";
         if($style_css) $style_css = 'style="'.$style_css.'"';

         $style_title = '';
         if($title_color) $style_title = "style=\"color: {$title_color}; background-color: {$title_color}\"";
         
         $el_class .= ' ' . $style;

         if($animate){
            $el_class .= ' wow';
            $el_class .= ' ' . $animate;
         }

         $link = gavias_render_textlangs($link);

         ?>
         <?php ob_start() ?>
         <div class="gsc-box-text clearfix <?php print $el_class; ?>" <?php print $style_css; ?>>
            <?php if(gavias_render_textlangs($sub_title)){ ?><div class="sub-title" <?php print $style_title; ?>><?php print gavias_render_textlangs($title) ?></div><?php } ?>
            <?php if(gavias_render_textlangs($title)){ ?>
               <div class="title" <?php print $style_title; ?>>
                  <?php if($link){ ?> <a href="<?php print $link ?>" <?php print $target ?>> <?php } ?> <?php print gavias_render_textlangs($title) ?> <?php if($link){ ?> </a><?php } ?>
               </div>
            <?php } ?>
            <?php if(gavias_render_textarealangs($content)){ ?>  
               <div class="box-content"><?php print gavias_render_textarealangs($content) ?></div>
            <?php } ?>   
         </div>
         <?php return ob_get_clean() ?>
        <?php            
      } 

      public function load_shortcode(){
         add_shortcode( 'box_text', array($this, 'sc_box_text'));
      }
   }
endif;   
