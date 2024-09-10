<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ListingController extends Controller
{
    public function real_value($value) {
        $return_value = str_replace("'", "@@@", $value);
        $return_value = str_replace('"', "###", $return_value);
        return $return_value;
    }
    public function index(){
        $listings = DB::select('SELECT * FROM `listing` ORDER BY `modified_date` DESC LIMIT 0,20');
        $listing_count = DB::select('SELECT COUNT(`id`) AS listing_count FROM `listing`');
        // $categories = DB::select("SELECT DISTINCT SUBSTRING_INDEX(`category`, ',', 1) AS categories FROM `listing` ORDER BY categories ASC");
        $categories_temp = DB::select("SELECT DISTINCT `category` FROM `listing` WHERE `category`<>''");
        $real_cate = array();
        foreach ($categories_temp as $categorie_temp) {
            $temps = explode(',', $categorie_temp->category);
            foreach ($temps as $temp){
                if (!in_array($temp, $real_cate)){
                    array_push($real_cate,$temp);
                }
            }
        }
        sort($real_cate);
        // dd($real_cate);
        $currentpage = 1;
        // return view('listing');
        // return view('listing', ['listings' => $listings], ['listing_count' => $listing_count], ['categories' => $categories]);
        return view('listing', compact('listings','listing_count','real_cate','currentpage'));
    }
    public function search(Request $request){
        // session()->put('searchform',$request);
        // Session::put('searchform', $request['listing_type']);
        // Session::put('searchform', $request);
        $formdata = '';
        
        $currentpage = 1;
        $sql = "SELECT * FROM `listing`";
        $count_sql = "SELECT COUNT(`id`) AS listing_count FROM `listing`";
        $listing_types = $request['listing_type'];
        $condition_flag = false;
        if($listing_types !=null ){
            
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            $sql_temp = '';
            foreach ($listing_types as $listing_type) {
                if ($sql_temp == ''){
                    $sql_temp = $sql_temp . "`type`='$listing_type'";
                }
                else {
                    $sql_temp = $sql_temp . " OR `type`='$listing_type'";
                }
                if ($formdata == ''){
                    $formdata = $formdata . "listing_type%5B%5D=" . $listing_type;
                }
                else {
                    $formdata = $formdata . "&listing_type%5B%5D=" . $listing_type;
                }
                
            }
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
        }

        $item_id = $request['item_id'];
        if($item_id != null){
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            else {
                $sql = $sql . " AND";
                $count_sql = $count_sql . " AND";
            }
            $sql_temp = '';
            $sql_temp = $sql_temp . "`item_id`='$item_id'";
            
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
            if ($formdata == ''){
                $formdata = $formdata . "item_id=" . $item_id;
            }
            else {
                $formdata = $formdata . "&item_id=" . $item_id;
            }
        }
        $categories = $request['category'];
        if($categories != null){
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            else {
                $sql = $sql . " AND";
                $count_sql = $count_sql . " AND";
            }
            $sql_temp = '';
            foreach ($categories as $category) {
                if ($sql_temp == ''){
                    $sql_temp = $sql_temp . "`category` LIKE '%$category%'";
                }
                else {
                    $sql_temp = $sql_temp . " OR `category` LIKE '%$category%'";
                }
                if ($formdata == ''){
                    $formdata = $formdata . "category%5B%5D=" . $category;
                }
                else {
                    $formdata = $formdata . "&category%5B%5D=" . $category;
                }
            }
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
        }

        $commercials = $request['commercial'];
        if($commercials != null){
            
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            else {
                $sql = $sql . " AND";
                $count_sql = $count_sql . " AND";
            }
            $sql_temp = '';
            foreach ($commercials as $commercial) {
                if ($sql_temp == ''){
                    $sql_temp = $sql_temp . "`commercial`='$commercial'";
                }
                else {
                    $sql_temp = $sql_temp . " OR `commercial`='$commercial'";
                }
                if ($formdata == ''){
                    $formdata = $formdata . "commercial%5B%5D=" . $commercial;
                }
                else {
                    $formdata = $formdata . "&commercial%5B%5D=" . $commercial;
                }
            }
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
        }

        $location = $request['location'];
        $location = $this->real_value($location);
        if($location != null){
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            else {
                $sql = $sql . " AND";
                $count_sql = $count_sql . " AND";
            }
            $sql_temp = '';
            $sql_temp = $sql_temp . "(`title` LIKE '%$location%' OR `description` LIKE '%$location%')";
            
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
            if ($formdata == ''){
                $formdata = $formdata . "location=" . $location;
            }
            else {
                $formdata = $formdata . "&location=" . $location;
            }
        }

        $minsaleprice = $request['minsaleprice'];
        if($minsaleprice != null){
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            else {
                $sql = $sql . " AND";
                $count_sql = $count_sql . " AND";
            }
            $sql_temp = '';
            $sql_temp = $sql_temp . "CAST(`sale_price` AS UNSIGNED)>'$minsaleprice'";
            
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
            if ($formdata == ''){
                $formdata = $formdata . "minsaleprice=" . $minsaleprice;
            }
            else {
                $formdata = $formdata . "&minsaleprice=" . $minsaleprice;
            }
        }

        $maxsaleprice = $request['maxsaleprice'];
        if($maxsaleprice != null){
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            else {
                $sql = $sql . " AND";
                $count_sql = $count_sql . " AND";
            }
            $sql_temp = '';
            $sql_temp = $sql_temp . "CAST(`sale_price` AS UNSIGNED)<'$maxsaleprice'";
            
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
            if ($formdata == ''){
                $formdata = $formdata . "maxsaleprice=" . $maxsaleprice;
            }
            else {
                $formdata = $formdata . "&maxsaleprice=" . $maxsaleprice;
            }
        }

        $minrentalprice = $request['minrentalprice'];
        if($minrentalprice != null){
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            else {
                $sql = $sql . " AND";
                $count_sql = $count_sql . " AND";
            }
            $sql_temp = '';
            $sql_temp = $sql_temp . "CAST(`rent_price` AS UNSIGNED)>'$minrentalprice'";
            
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
            if ($formdata == ''){
                $formdata = $formdata . "minrentalprice=" . $minrentalprice;
            }
            else {
                $formdata = $formdata . "&minrentalprice=" . $minrentalprice;
            }
        }

        $maxrentalprice = $request['maxrentalprice'];
        if($maxrentalprice != null){
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            else {
                $sql = $sql . " AND";
                $count_sql = $count_sql . " AND";
            }
            $sql_temp = '';
            $sql_temp = $sql_temp . "CAST(`rent_price` AS UNSIGNED)<'$maxrentalprice'";
            
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
            if ($formdata == ''){
                $formdata = $formdata . "maxrentalprice=" . $maxrentalprice;
            }
            else {
                $formdata = $formdata . "&maxrentalprice=" . $maxrentalprice;
            }
        }

        $bedrooms = $request['bedrooms'];
        if($bedrooms != null){
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            else {
                $sql = $sql . " AND";
                $count_sql = $count_sql . " AND";
            }
            $sql_temp = '';
            foreach ($bedrooms as $bedroom) {
                if ($sql_temp == ''){
                    $sql_temp = $sql_temp . "`bedrooms`='$bedroom'";
                }
                else {
                    $sql_temp = $sql_temp . " OR `bedrooms`='$bedroom'";
                }

                if ($formdata == ''){
                    $formdata = $formdata . "bedrooms%5B%5D=" . $bedroom;
                }
                else {
                    $formdata = $formdata . "&bedrooms%5B%5D=" . $bedroom;
                }
            }
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
        }

        $ownerid = $request['ownerid'];
        if($ownerid != null){
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            else {
                $sql = $sql . " AND";
                $count_sql = $count_sql . " AND";
            }
            $sql_temp = '';
            $sql_temp = $sql_temp . "`owner_id`='$ownerid'";
            
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
            if ($formdata == ''){
                $formdata = $formdata . "ownerid=" . $ownerid;
            }
            else {
                $formdata = $formdata . "&ownerid=" . $ownerid;
            }
        }

        $ownername = $request['ownername'];
        if($ownername != null){
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            else {
                $sql = $sql . " AND";
                $count_sql = $count_sql . " AND";
            }
            $sql_temp = '';
            $sql_temp = $sql_temp . "`ownername`='$ownername'";
            
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
            if ($formdata == ''){
                $formdata = $formdata . "ownername=" . $ownername;
            }
            else {
                $formdata = $formdata . "&ownername=" . $ownername;
            }
        }

        $mobile = $request['mobile'];
        if($mobile != null){
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            else {
                $sql = $sql . " AND";
                $count_sql = $count_sql . " AND";
            }
            $sql_temp = '';
            $sql_temp = $sql_temp . "`mobile`='$mobile'";
            
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
            if ($formdata == ''){
                $formdata = $formdata . "mobile=" . $mobile;
            }
            else {
                $formdata = $formdata . "&mobile=" . $mobile;
            }
        }
        $labels = $request['labels'];
        if($labels != null){
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            else {
                $sql = $sql . " AND";
                $count_sql = $count_sql . " AND";
            }
            $sql_temp = '';
            foreach ($labels as $label) {
                if ($sql_temp == ''){
                    $sql_temp = $sql_temp . $label . "<>''";
                }
                else {
                    $sql_temp = $sql_temp . " OR ". $label. "<>''";
                }

                if ($formdata == ''){
                    $formdata = $formdata . "labels%5B%5D=" . $label;
                }
                else {
                    $formdata = $formdata . "&labels%5B%5D=" . $label;
                }
            }
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
        }

        $modifieddate = $request['modifieddate'];
        if($modifieddate != null){
            
            $sql_temp = '';
            $sql_temp = $sql_temp . "ORDER BY `modified_date` " . $modifieddate;
            
            $sql = $sql . " " . $sql_temp;
            // $count_sql = $count_sql . " (" . $sql_temp . ")";
            if ($formdata == ''){
                $formdata = $formdata . "modifieddate=" . $modifieddate;
            }
            else {
                $formdata = $formdata . "&modifieddate=" . $modifieddate;
            }
        }
        else{
            
            $sql_temp = '';
            $sql_temp = $sql_temp . "ORDER BY `modified_date` DESC";
            
            $sql = $sql . " " . $sql_temp;

        }
        $sql = $sql . " LIMIT 0,20";
        // $count_sql = $count_sql . " LIMIT 0,20";
        // dd($count_sql);
        // dd($request['listing_type']);
        $listings = DB::select($sql);
        $listing_count = DB::select($count_sql);
        // $categories = DB::select("SELECT DISTINCT SUBSTRING_INDEX(`category`, ',', 1) AS categories FROM `listing` ORDER BY categories ASC");
        $categories_temp = DB::select("SELECT DISTINCT `category` FROM `listing` WHERE `category`<>''");
        $real_cate = array();
        foreach ($categories_temp as $categorie_temp) {
            $temps = explode(',', $categorie_temp->category);
            foreach ($temps as $temp){
                if (!in_array($temp, $real_cate)){
                    array_push($real_cate,$temp);
                }
            }
        }
        sort($real_cate);
        return view('listing', compact('listings','listing_count','real_cate','request','currentpage','formdata'));
    }

    public function listingpagenation($currentpage) {
        $limit_offset = 20*($currentpage-1);
        // dd($limit_offset); 
        $listings = DB::select('SELECT * FROM `listing` ORDER BY `modified_date` DESC LIMIT ' . $limit_offset . ',20');
        $listing_count = DB::select('SELECT COUNT(`id`) AS listing_count FROM `listing`');
        // $categories = DB::select("SELECT DISTINCT SUBSTRING_INDEX(`category`, ',', 1) AS categories FROM `listing` ORDER BY categories ASC");
        $categories_temp = DB::select("SELECT DISTINCT `category` FROM `listing` WHERE `category`<>''");
        $real_cate = array();
        foreach ($categories_temp as $categorie_temp) {
            $temps = explode(',', $categorie_temp->category);
            foreach ($temps as $temp){
                if (!in_array($temp, $real_cate)){
                    array_push($real_cate,$temp);
                }
            }
        }
        sort($real_cate);
        // dd($categories);
        // $currentpage = 1;
        // return view('listing');
        // return view('listing', ['listings' => $listings], ['listing_count' => $listing_count], ['categories' => $categories]);
        return view('listing', compact('listings','listing_count','real_cate','currentpage'));
    }

    public function searchpagenation($currentpage, Request $request){
        $formdata = '';
        $limit_offset = 20*($currentpage-1);
        // $currentpage = 1;
        $sql = "SELECT * FROM `listing`";
        $count_sql = "SELECT COUNT(`id`) AS listing_count FROM `listing`";
        $listing_types = $request['listing_type'];
        $condition_flag = false;
        if($listing_types !=null ){
            
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            $sql_temp = '';
            foreach ($listing_types as $listing_type) {
                if ($sql_temp == ''){
                    $sql_temp = $sql_temp . "`type`='$listing_type'";
                }
                else {
                    $sql_temp = $sql_temp . " OR `type`='$listing_type'";
                }
                if ($formdata == ''){
                    $formdata = $formdata . "listing_type%5B%5D=" . $listing_type;
                }
                else {
                    $formdata = $formdata . "&listing_type%5B%5D=" . $listing_type;
                }
                
            }
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
        }
        $item_id = $request['item_id'];
        if($item_id != null){
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            else {
                $sql = $sql . " AND";
                $count_sql = $count_sql . " AND";
            }
            $sql_temp = '';
            $sql_temp = $sql_temp . "`item_id`='$item_id'";
            
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
            if ($formdata == ''){
                $formdata = $formdata . "item_id=" . $item_id;
            }
            else {
                $formdata = $formdata . "&item_id=" . $item_id;
            }
        }
        $categories = $request['category'];
        if($categories != null){
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            else {
                $sql = $sql . " AND";
                $count_sql = $count_sql . " AND";
            }
            $sql_temp = '';
            foreach ($categories as $category) {
                if ($sql_temp == ''){
                    $sql_temp = $sql_temp . "`category` LIKE '%$category%'";
                }
                else {
                    $sql_temp = $sql_temp . " OR `category` LIKE '%$category%'";
                }
                if ($formdata == ''){
                    $formdata = $formdata . "category%5B%5D=" . $category;
                }
                else {
                    $formdata = $formdata . "&category%5B%5D=" . $category;
                }
            }
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
        }

        $commercials = $request['commercial'];
        if($commercials != null){
            
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            else {
                $sql = $sql . " AND";
                $count_sql = $count_sql . " AND";
            }
            $sql_temp = '';
            foreach ($commercials as $commercial) {
                if ($sql_temp == ''){
                    $sql_temp = $sql_temp . "`commercial`='$commercial'";
                }
                else {
                    $sql_temp = $sql_temp . " OR `commercial`='$commercial'";
                }
                if ($formdata == ''){
                    $formdata = $formdata . "commercial%5B%5D=" . $commercial;
                }
                else {
                    $formdata = $formdata . "&commercial%5B%5D=" . $commercial;
                }
            }
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
        }

        $location = $request['location'];
        $location = $this->real_value($location);
        if($location != null){
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            else {
                $sql = $sql . " AND";
                $count_sql = $count_sql . " AND";
            }
            $sql_temp = '';
            $sql_temp = $sql_temp . "(`title` LIKE '%$location%' OR `description` LIKE '%$location%')";
            
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
            if ($formdata == ''){
                $formdata = $formdata . "location=" . $location;
            }
            else {
                $formdata = $formdata . "&location=" . $location;
            }
        }

        $minsaleprice = $request['minsaleprice'];
        if($minsaleprice != null){
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            else {
                $sql = $sql . " AND";
                $count_sql = $count_sql . " AND";
            }
            $sql_temp = '';
            $sql_temp = $sql_temp . "CAST(`sale_price` AS UNSIGNED)>'$minsaleprice'";
            
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
            if ($formdata == ''){
                $formdata = $formdata . "minsaleprice=" . $minsaleprice;
            }
            else {
                $formdata = $formdata . "&minsaleprice=" . $minsaleprice;
            }
        }

        $maxsaleprice = $request['maxsaleprice'];
        if($maxsaleprice != null){
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            else {
                $sql = $sql . " AND";
                $count_sql = $count_sql . " AND";
            }
            $sql_temp = '';
            $sql_temp = $sql_temp . "CAST(`sale_price` AS UNSIGNED)<'$maxsaleprice'";
            
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
            if ($formdata == ''){
                $formdata = $formdata . "maxsaleprice=" . $maxsaleprice;
            }
            else {
                $formdata = $formdata . "&maxsaleprice=" . $maxsaleprice;
            }
        }

        $minrentalprice = $request['minrentalprice'];
        if($minrentalprice != null){
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            else {
                $sql = $sql . " AND";
                $count_sql = $count_sql . " AND";
            }
            $sql_temp = '';
            $sql_temp = $sql_temp . "CAST(`rent_price` AS UNSIGNED)>'$minrentalprice'";
            
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
            if ($formdata == ''){
                $formdata = $formdata . "minrentalprice=" . $minrentalprice;
            }
            else {
                $formdata = $formdata . "&minrentalprice=" . $minrentalprice;
            }
        }

        $maxrentalprice = $request['maxrentalprice'];
        if($maxrentalprice != null){
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            else {
                $sql = $sql . " AND";
                $count_sql = $count_sql . " AND";
            }
            $sql_temp = '';
            $sql_temp = $sql_temp . "CAST(`rent_price` AS UNSIGNED)<'$maxrentalprice'";
            
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
            if ($formdata == ''){
                $formdata = $formdata . "maxrentalprice=" . $maxrentalprice;
            }
            else {
                $formdata = $formdata . "&maxrentalprice=" . $maxrentalprice;
            }
        }

        $bedrooms = $request['bedrooms'];
        if($bedrooms != null){
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            else {
                $sql = $sql . " AND";
                $count_sql = $count_sql . " AND";
            }
            $sql_temp = '';
            foreach ($bedrooms as $bedroom) {
                if ($sql_temp == ''){
                    $sql_temp = $sql_temp . "`bedrooms`='$bedroom'";
                }
                else {
                    $sql_temp = $sql_temp . " OR `bedrooms`='$bedroom'";
                }

                if ($formdata == ''){
                    $formdata = $formdata . "bedrooms%5B%5D=" . $bedroom;
                }
                else {
                    $formdata = $formdata . "&bedrooms%5B%5D=" . $bedroom;
                }
            }
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
        }

        $ownerid = $request['ownerid'];
        if($ownerid != null){
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            else {
                $sql = $sql . " AND";
                $count_sql = $count_sql . " AND";
            }
            $sql_temp = '';
            $sql_temp = $sql_temp . "`owner_id`='$ownerid'";
            
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
            if ($formdata == ''){
                $formdata = $formdata . "ownerid=" . $ownerid;
            }
            else {
                $formdata = $formdata . "&ownerid=" . $ownerid;
            }
        }

        $ownername = $request['ownername'];
        if($ownername != null){
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            else {
                $sql = $sql . " AND";
                $count_sql = $count_sql . " AND";
            }
            $sql_temp = '';
            $sql_temp = $sql_temp . "`ownername`='$ownername'";
            
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
            if ($formdata == ''){
                $formdata = $formdata . "ownername=" . $ownername;
            }
            else {
                $formdata = $formdata . "&ownername=" . $ownername;
            }
        }

        $mobile = $request['mobile'];
        if($mobile != null){
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            else {
                $sql = $sql . " AND";
                $count_sql = $count_sql . " AND";
            }
            $sql_temp = '';
            $sql_temp = $sql_temp . "`mobile`='$mobile'";
            
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
            if ($formdata == ''){
                $formdata = $formdata . "mobile=" . $mobile;
            }
            else {
                $formdata = $formdata . "&mobile=" . $mobile;
            }
        }
        $labels = $request['labels'];
        if($labels != null){
            if ($condition_flag == false){
                $sql = $sql . " WHERE";
                $count_sql = $count_sql . " WHERE";
                $condition_flag = true;
            }
            else {
                $sql = $sql . " AND";
                $count_sql = $count_sql . " AND";
            }
            $sql_temp = '';
            foreach ($labels as $label) {
                if ($sql_temp == ''){
                    $sql_temp = $sql_temp . $label . "<>''";
                }
                else {
                    $sql_temp = $sql_temp . " OR ". $label. "<>''";
                }

                if ($formdata == ''){
                    $formdata = $formdata . "labels%5B%5D=" . $label;
                }
                else {
                    $formdata = $formdata . "&labels%5B%5D=" . $label;
                }
            }
            $sql = $sql . " (" . $sql_temp . ")";
            $count_sql = $count_sql . " (" . $sql_temp . ")";
        }
        $modifieddate = $request['modifieddate'];
        if($modifieddate != null){
            
            $sql_temp = '';
            $sql_temp = $sql_temp . "ORDER BY `modified_date` " . $modifieddate;
            
            $sql = $sql . " " . $sql_temp;
            // $count_sql = $count_sql . " (" . $sql_temp . ")";
            if ($formdata == ''){
                $formdata = $formdata . "modifieddate=" . $modifieddate;
            }
            else {
                $formdata = $formdata . "&modifieddate=" . $modifieddate;
            }
        }
        else {
            $sql_temp = '';
            $sql_temp = $sql_temp . "ORDER BY `modified_date` DESC";
            
            $sql = $sql . " " . $sql_temp;
        }

        $sql = $sql . " LIMIT " . $limit_offset . ",20";
        // $count_sql = $count_sql . " LIMIT 0,20";
        // dd($count_sql);
        // dd($request['listing_type']);
        $listings = DB::select($sql);
        $listing_count = DB::select($count_sql);
        // $categories = DB::select("SELECT DISTINCT SUBSTRING_INDEX(`category`, ',', 1) AS categories FROM `listing` ORDER BY categories ASC");
        $categories_temp = DB::select("SELECT DISTINCT `category` FROM `listing` WHERE `category`<>''");
        $real_cate = array();
        foreach ($categories_temp as $categorie_temp) {
            $temps = explode(',', $categorie_temp->category);
            foreach ($temps as $temp){
                if (!in_array($temp, $real_cate)){
                    array_push($real_cate,$temp);
                }
            }
        }
        sort($real_cate);
        return view('listing', compact('listings','listing_count','real_cate','request','currentpage','formdata'));
    }

}
