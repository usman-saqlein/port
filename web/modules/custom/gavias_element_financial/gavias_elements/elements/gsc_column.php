<?php 
namespace Drupal\gavias_blockbuilder\shortcodes;
if(!class_exists('gsc_column')):
   class gsc_column{

      public function render_form(){
         $fields = array(
            'type' => 'gsc_column',
            'title' => t('Custom Text'),
            'size' => 3,
            'fields' => array(
               
               array(
                  'id'     => 'title',
                  'type'      => 'text',
                  'title'  => t('Title'),
                   'class'     => 'display-admin'
               ),
               array(
                  'id'           => 'content',
                  'type'         => 'textarealangs',
                  'title'        => t('Column content'),
                  'desc'         => t('Shortcodes and HTML tags allowed.'),
                  'shortcodes'   => 'on'
               ),
               array(
                  'id'        => 'style',
                  'type'      => 'select',
                  'title'     => t('Style display'),
                  'options'   => array(
                     ''   => 'Default',
                     'text-quote'      => 'Text Quote(big-padding, max-with: 820px)',
                     'text-quote-2'    => 'Text Quote 2(medium-padding, max-with: 980px)',
                  )
               ), 
               array(
                  'id'     => 'animate',
                  'type'      => 'select',
                  'title'  => ('Animation'),
                  'desc'  => t('Entrance animation for element'),
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
         return $fields;
      }


      public function render_content( $item ) {
         print self::sc_column( $item['fields'] );
      }


      public static function sc_column( $attr, $content = null ){
         extract(shortcode_atts(array(
            'title'      => '',
            'content'    => '',
            'style'      => '',
            'el_class'   => '',
            'animate'    => ''
         ), $attr));
         $el_class .= ' ' . $style;
         if($animate){
            $el_class .= ' wow';
            $el_class .= ' ' . $animate;
         }
         $ouput = '';
         $ouput .= '<div class="column-content '.$el_class.'">';
         $ouput .= do_shortcode( gavias_render_textarealangs($content) );
         $ouput .= '</div>';
         return $ouput;
      }

      public function load_shortcode(){
         add_shortcode( 'column', array('gsc_column', 'sc_column') );
      }
   }
 endif;  



