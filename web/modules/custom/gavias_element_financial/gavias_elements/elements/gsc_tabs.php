<?php 
namespace Drupal\gavias_blockbuilder\shortcodes;
if(!class_exists('gsc_tabs')):
   global $tabs_array, $tabs_count;
   class gsc_tabs{

      public function render_form(){
         $fields = array(
            'type'   => 'gsc_tabs',
            'title'  => t('Tabs'), 
            'size'   => 3, 
            
            'fields' => array(
         
               array(
                  'id'        => 'title',
                  'type'      => 'text',
                  'title'     => t('Title for admin'),
                  'class'     => 'display-admin'
               ),
            
               array(
                  'id'        => 'type',
                  'type'      => 'select',
                  'options'   => array(
                     'horizontal'   => 'Horizontal',
                     'vertical'     => 'Vertical', 
                  ),
                  'title'  => t('Style'),
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
         for($i=1; $i<=8; $i++){
            $fields['fields'][] = array(
               'id'     => "info_${i}",
               'type'   => 'info',
               'desc'   => "Information for item {$i}"
            );
            $fields['fields'][] = array(
               'id'        => "title_{$i}",
               'type'      => 'textlangs',
               'title'     => t("Title {$i}")
            );
            $fields['fields'][] = array(
               'id'           => "content_{$i}",
               'type'         => 'textarealangs',
               'title'        => t("Content {$i}")
            );
         }
         return $fields;
      }

      public function render_content( $item ) {
         print self::render_tabs( $item['fields'] );
      }

      public static function render_tabs( $attr, $content = null ){
         global $tabs_array, $tabs_count;
         $default = array(
            'title'     => '',
            'type'      => '',
            'el_class'  => '',
            'animate'   => ''
         );

         for($i=1; $i<=8; $i++){
            $default["title_{$i}"] = '';
            $default["content_{$i}"] = '';
         }
         extract(shortcode_atts($default, $attr));

         $uid = 'uid-' . gavias_blockbuilder_makeid();
         
         if($animate){
            $el_class .= ' wow';
            $el_class .= ' '. $animate;
         }
          ob_start() ?>
         <div class="gsc-tabs <?php print $el_class ?>">
            <div class="tabs_wrapper tabs_<?php print $type ?>">
               <ul class="nav nav-tabs">
                  <?php for($i=1; $i<=8; $i++){ ?>
                     <?php 
                        $title = "title_{$i}";
                        $content = "content_{$i}";
                     ?>
                     <?php if(gavias_render_textlangs($$title)){ ?>
                        <li <?php print($i==1?'class="active"':'') ?>><a data-toggle="tab" href="#<?php print ($uid .'-'. $i) ?>">  <?php print gavias_render_textlangs($$title) ?> </a></li>
                     <?php } ?>
                  <?php } ?>
               </ul>
               <div class="tab-content">
                  <?php for($i=1; $i<=8; $i++){ ?>
                     <?php 
                        $title = "title_{$i}";
                        $content = "content_{$i}";
                     ?>
                     <?php if(gavias_render_textlangs($$title)){ ?>
                        <div id="<?php print($uid .'-'. $i) ?>" class="tab-pane fade in <?php print($i==1?'active':'') ?>"><?php print do_shortcode( gavias_render_textarealangs($$content) ) ?></div>
                     <?php } ?>
                  <?php } ?>
               </div>
            </div>
         </div>
         <?php return ob_get_clean() ?>
      <?php  
      return $output;
      }

      public function sc_tabs( $attr, $content = null ){
         global $tabs_array, $tabs_count;
         extract(shortcode_atts(array(
            'title'     => '',
            'uid'       => 'tab-',
            'type'      => '',
            'el_class'  => '',
            'animate'   => ''
         ), $attr)); 
         do_shortcode( $content );
         $_id = gavias_blockbuilder_makeid();
         $uid .= $_id;
         if($animate){
            $el_class .= ' wow';
            $el_class .= ' '. $animate;
         }
         $output = '<div class="gsc-tabs '.$el_class.'">';
         if( is_array( $tabs_array ) ){
            $output .= '<div class="tabs_wrapper tabs_'. $type .'">';
               // content
               $output .= '<ul class="nav nav-tabs">';
                  $i = 1;
                  $output_tabs = '';
                  foreach( $tabs_array as $tab )
                  {
                     $icon = '';
                     if(isset($tab['icon']) && $tab['icon']){
                        $icon = '<span><i class="fa ' . $tab['icon'] . '"></i></span>';
                     }
                     $output .= '<li '.($i==1?'class="active"':'').'><a data-toggle="tab" href="#'. $uid .'-'. $i .'">' . $icon . $tab['title'] .'</a></li>';
                     $output_tabs .= '<div id="'. $uid .'-'. $i .'" class="tab-pane fade in '.($i==1?'active':'').'">'. do_shortcode( $tab['content'] ) .'</div>';
                     $i++;
                  }
               $output .= '</ul>';
               
               // titles
               $output .= '<div class="tab-content">';
                  $output .= $output_tabs;
               $output .= '</div>';
            $output .= '</div>';
            
            $tabs_array = '';
            $tabs_count = 0;  
         }
         $output .= '</div>';
         return $output;
      }



      public function sc_tab( $attr, $content = null ){
         global $tabs_array, $tabs_count;
         
         extract(shortcode_atts(array(
            'title' => 'Tab title',
         ), $attr));

         $tabs_array[] = array(
            'title' => $title,
            'content' => do_shortcode( $content )
         );

         $tabs_count++;
         return true;
      }

      public function load_shortcode(){
         add_shortcode( 'tab', array($this, 'sc_tab') );
         add_shortcode( 'tabs', array($this, 'sc_tabs') );
      }
   }
endif;


