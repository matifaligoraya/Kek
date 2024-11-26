<?php
class WPBakeryKEKMsgAnimation {
    public function __construct() {
        add_action('vc_before_init', array($this, 'register_elements'), 40);
        add_shortcode('kek_msg_animation', array($this, 'render_kek_msg_animation'), 40);
    }

    public function register_elements() {
        vc_map(array(
            'name' => __('KEK Msg Animation', 'kek'),
            'base' => 'kek_msg_animation',
            'category' => __('Kek Essentials', 'kek'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => __('Animation Duration (in seconds)', 'kek'),
                    'param_name' => 'animation_duration',
                    'value' => '10',
                    'description' => __('Enter the total duration for the animation loop.', 'kek'),
                ),
                array(
                    'type' => 'param_group',
                    'heading' => __('Messages', 'kek'),
                    'param_name' => 'messages',
                    'params' => array(
                        array(
                            'type' => 'iconpicker',
                            'heading' => __('Icon', 'kek'),
                            'param_name' => 'icon',
                            'settings' => array(
                                'emptyIcon' => true,
                                'iconsPerPage' => 200,
                            ),
                            'description' => __('Choose an icon to display with the message.', 'kek'),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Message Text', 'kek'),
                            'param_name' => 'message_text',
                            'value' => __('Your message here.', 'kek'),
                            'description' => __('Enter the message text.', 'kek'),
                        )
                    ),
                ),
            ),
        ));
    }

    public function render_kek_msg_animation($atts) {
        $atts = shortcode_atts(array(
            'animation_duration' => '10', // default animation duration
            'messages' => '', // dynamic messages
        ), $atts);
    
        $messages = vc_param_group_parse_atts($atts['messages']);
        ob_start();
        ?>
           <div class="heart-container">
    <i class="fas fa-heart heart-icon"></i>
</div>
        <section class="chat">
     
            <div class="chat__inner">
                <?php 
                if (!empty($messages)) {
                    $timeline = 1; // Start timeline at 1 second
                    foreach ($messages as $message) {
                        $icon = isset($message['icon']) ? esc_attr($message['icon']) : 'fab fa-instagram';
                        $text = isset($message['message_text']) ? wp_kses($message['message_text'], array(
                            'span' => array(
                                'class' => array(),
                            ),
                            'i' => array(
                                'class' => array(),
                            ),
                            'b' => array(),
                            'strong' => array(),
                            'em' => array(),
                            'u' => array(),
                            'a' => array(
                                'href' => array(),
                                'target' => array(),
                                'rel' => array(),
                            ),
                        )) : '';
                        ?>
                        <div class="chat__message chat__message_A" style="--timeline: <?php echo $timeline; ?>s;">
                            <div class="chat__content">
                                <i class="<?php echo $icon; ?>"></i> <?php echo $text; ?>
                            </div>
                        </div>
                        <?php
                        $timeline++; // Increment timeline for each message
                    }
                }
                ?>
                   <div class="rotate-img">
     
     <img src="<?php echo kek_URI ?>assets/images/send.png" style="width: 32px;" alt="Share Icon">
    </div>         
            </div>
            
        </section>
        <style>
            .heart-container {
    position: absolute;
    width: 100px;
    height: 100px;
    right:100px;
    z-index: 100;
}

.heart-icon {
    font-size: 40px;
    color: #e1306c;
    opacity: 0;
    animation: pop-heart 1s infinite;
}

@keyframes pop-heart {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    40% {
        transform: scale(0.8);
        opacity: 0.7;
    }
    50% {
        transform: scale(1);
        opacity: 0.9;
    }
    70% {
        transform: scale(1.4);
        opacity: 1;
    }
    90% {
        transform: scale(1);
        opacity: 0.91;
    }
    100% {
        transform: scale(0.8);
        opacity: 0;
    }
}
            .chat__content span {
  font-weight: bold;
}
      .chat {
   display: flex;
   flex-direction: column-reverse;
   height: 8rem;
   background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath fill='%23000066' d='M51.3,-59.7C65.8,-60,76.5,-44.2,77.9,-28.1C79.2,-12.1,71.2,4.2,60.4,14.2C49.7,24.2,36.3,27.8,25.8,38.4C15.2,49,7.6,66.5,-1.7,68.7C-10.9,71,-21.9,58.1,-33.5,47.9C-45.2,37.7,-57.6,30.2,-65.4,18.4C-73.2,6.5,-76.4,-9.7,-69.3,-19.8C-62.2,-29.9,-44.9,-34,-31.7,-34.1C-18.4,-34.3,-9.2,-30.5,4.6,-36.8C18.4,-43.1,36.7,-59.5,51.3,-59.7Z' transform='translate(100 100)'/%3E%3C/svg%3E");
   font: 1rem/1.5 "Open Sans", Arial;
   color: #313131;   
   background-size: cover;
    background-position: center;
  
   position: relative;
   overflow: hidden;
   width: 500px;
    height: 325px;
}
.chat__inner {
   display: flex;
   flex-direction: column;
   padding: 0.75rem;
   width: 100%;
}

.chat__message {
   width: 60%;
   display: flex;
   align-items: flex-end;
   transform-origin: 0 100%;
   padding-top: 0;
   transform: scale(0);
   max-height: 0;
   overflow: hidden;
   animation: message 0.15s ease-out forwards;
   animation-delay: var(--timeline);

   --bgcolor: #f0f0f0;
   --radius: 12px;
}

.chat__message_A {
   --bgcolor: #fff;
   --radius: 15px;
   margin: 0 auto;
}

.chat__content {
   flex: 0 1 auto;
   padding: 0.5rem 1rem;
   margin: 0 0.1rem;
   background: var(--bgcolor);
   border-radius: var(--radius);
   box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
   font-size: 0.9rem;
   display: flex;
   align-items: center;
   gap: 0.5rem;
}

.chat__content i {
   font-size: 1.2rem;
   color: #e1306c; /* Instagram color */
}

.chat__content span {
   color: #e1306c; /* Instagram username color */
   font-weight: bold;
}

@keyframes message {
   0% { 
      max-height: 100vmax; 
   }
   80% { 
      transform: scale(1.1); 
   }
   100% { 
      transform: scale(1); 
      max-height: 100vmax; 
      overflow: visible; 
      padding-top: 1rem;
   }
}


        </style>
        <?php
        return ob_get_clean();
    }
}

// Instantiate the class
new WPBakeryKEKMsgAnimation();
