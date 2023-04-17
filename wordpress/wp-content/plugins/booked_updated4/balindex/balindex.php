<?php

/**
 * @author Yusuf Caliskan
 * @email yusufocaliskan@gmail.com
 */
class Balindex{

    /**
     * Holds WPDB global variable
     */
    public $DB;

    /**
     * Shorted days of weeek
     */
    public function __construct()
    {
        global $wpdb;
        $this->DB= $wpdb;
    }

    /**
     * Gets all the producst from the database
     * with its datails that stored on wp_wc_product_meta_lookup tabel
     */
    public function getAllProducts()
    {
        $select = $this->DB->get_results("
                    SELECT * FROM ".$this->DB->prefix."posts 
                    LEFT JOIN ".$this->DB->prefix."wc_product_meta_lookup 
                        ON ".$this->DB->prefix."posts.ID = ".$this->DB->prefix."wc_product_meta_lookup.product_id
                        
                    WHERE ".$this->DB->prefix."posts.post_type = 'product'
                    ");
        return $select;
    }

    /**
     * Get Product by its name
     */
    public function getProductByTitle($title)
    {

        $select = $this->DB->get_row("
                    SELECT * FROM ".$this->DB->prefix."posts 
                    LEFT JOIN ".$this->DB->prefix."wc_product_meta_lookup 
                        ON ".$this->DB->prefix."posts.ID = ".$this->DB->prefix."wc_product_meta_lookup.product_id
                        
                    WHERE ".$this->DB->prefix."posts.post_type = 'product' AND ".$this->DB->prefix."posts.post_title = '$title'
                    ");
        return $select;
    }
    /**
     * Returns all the products that added to the timeslots
     */
    public function getTimeslotProducts($data = [])
    {
        $booked_default = get_option( 'booked_defaults' );
        
        //Removes the same values
        if($booked_default['productIds'])
        {
            return array_unique($booked_default['productIds']);
        }
        
    }

    public function getProductByTimeSlot($day = '')
    {
        $booked_default = get_option( 'booked_defaults' );
        
        //Removes the same values
        if($booked_default['productIds'])
        {
            return $booked_default[$this->shortDaynName($day).'-details'];
        }
        
    }

    public function shortDaynName($day)
    {
        return date('D', strtotime($day));
    }
    

    
    

}