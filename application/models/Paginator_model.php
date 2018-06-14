<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paginator_model extends CI_Model {

    //declare all internal (private) variables, only accessbile within this class
    private $_conn;
    private $_limit; //records (rows) to show per page
    private $_page; //current page
    private $_query = 'select * from products order by created_at desc';
    private $_total;
    private $_row_start;
    private $_sort= ' order by id';
    private $_category;
    private $_product_address= './products/ceva';

    //constructor method is called automatically when object is instantiated with new keyword
    public function __construct()
    {
        $conn = <<<EOD
select products.id, products.name,  products.price, SUBSTRING(products.description, 1, 20) as description, products.created_at, products.updated_at, categories.name as category from products
	inner join categories on categories.id= products.id_category
EOD;
        $rs = $this->db->query($conn)->result();
        $this->_total = count($rs); //total number of rows
    }

    //LIMIT DATA
    //all it does is limits the data returned and returns everything as $result object
    public function getData($category, $page = 1, $limit=1, $sort=null ) { //set default argument values
        if ($sort!==null) $this->_sort=$sort;
        $this->_limit = $limit;
        $this->_page = $page;
        $this->_category = $category;
        $this->_query = "select products.id, products.name, products.price, products.description, products.created_at, products.updated_at, categories.name as category from products
		                                inner join categories on categories.id= products.id_category
										where categories.name like '" . $category . "' " . $this->_sort;

        //no limiting necessary, use query as it is
        $query2 = $this->db->query($this->_query);
        $this->_total = $query2->num_rows(); //total number of rows


        if ( $this->_limit == 'all' ) {
            $query = $this->_query;
        }

        else {
            //echo ( ( $this->_page - 1 ) * $this->_limit );die;
            //create the query, limiting records from page, to limit
            $this->_row_start = ( ( $this->_page -1 ) * $this->_limit );
            $query = $this->_query .
                //add to original query: ( minus one because of the way SQL works )
            " LIMIT {$this->_limit}
            OFFSET {$this->_row_start} ROWS";
        }

        //echo $query;die;
        $query2 = $this->db->query($query);
        $rs = $query2->result_array();

        if ($rs) return $rs;
        return;

        foreach ($rs as $row) {
            //store this array in $result->data below
            $results[]  = $row;
        }

            //print_r($results);die;

        //return data as object, new stdClass() creates new empty object
        $result         = new stdClass();
        $result->page   = $this->_page;
        $result->limit  = $this->_limit;
        $result->total  = $this->_total;
        $result->data   = $results; //$result->data = array

        //print_r($result);die;
        return $rs; //object
    }

    //PRINT LINKS
    public function createLinks( $links, $list_class )
    {
        //return empty result string, no links necessary
        if ( $this->_limit == 'all' ) {
            return '';
        }

        //get the last page number
        $last = ceil( $this->_total / $this->_limit );


        //calculate start of range for link printing
        $start = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;

        //calculate end of range for link printing
        $end = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;

        //debugging
//        echo '$total: '.$this->_total.' | '; //total rows
//        echo '$row_start: '.$this->_row_start.' | '; //total rows
//        echo '$limit: '.$this->_limit.' | '; //total rows per query
//        echo '$start: '.$start.' | '; //start printing links from
//        echo '$end: '.$end.' | '; //end printing links at
//        echo '$last: '.$last.' | '; //last page
//        echo '$page: '.$this->_page.' | '; //current page
//        echo '$links: '.$links.' <br /> '; //links

        //ul boot strap class - "pagination pagination-sm"
        $html = '<ul class="' . $list_class . '">';

        $class = ( $this->_page == 1 ) ? "disabled" : ""; //disable previous page link <<<

        //create the links and pass limit and page as $_GET parameters

        //$this->_page - 1 = previous page (<<< link )
        $previous_page = ( $this->_page == 1 ) ?
            '<a href=""><li class="' . $class . '">&laquo;</a></li>' : //remove link from previous button
            '<li class="' . $class . '"><a href="' . ( $this->_page - 1 ) . '">&laquo;</a></li>';

        $html .= $previous_page;

        if ( $start > 1 ) { //print ... before (previous <<< link)
            $html .= '<li><a href="1">1</a></li>'; //print first page link
            $html .= '<li class="disabled"><span>...</span></li>'; //print 3 dots if not on first page
        }

        //print all the numbered page links
        for ( $i = $start ; $i <= $end; $i++ ) {
            $class = ( $this->_page == $i ) ? "active" : ""; //highlight current page
            $html .= '<li class="' . $class . '"><a href="' . $i . '">' . $i . '</a></li>';
        }

        if ( $end < $last ) { //print ... before next page (>>> link)
            $html .= '<li class="disabled"><span>...</span></li>'; //print 3 dots if not on last page
            $html .= '<li><a href="' . $last . '">' . $last . '</a></li>'; //print last page link
        }

        $class = ( $this->_page == $last ) ? "disabled" : ""; //disable (>>> next page link)

        //$this->_page + 1 = next page (>>> link)
        $next_page = ( $this->_page == $last) ?
            '<li class="' . $class . '"><a href="">&raquo;</a></li>' : //remove link from next button
            '<li class="' . $class . '"><a href="'.( $this->_page + 1 ) . '">&raquo;</a></li>';

        $html .= $next_page;
        $html .= '</ul>';

        return $html;
    }

    public function ajaxSortingProduct()
    {

        if ($_POST) {
            $this->_sort = $_POST['sort'];
            switch ($this->_sort) {
                case "1":
                    $this->_sort = " order by id";
                    break;
                case "2":
                    $this->_sort = " order by id";
                    break;
                case "3":
                    $this->_sort = " order by created_at desc";
                    break;
                case "4":
                    $this->_sort = " order by price asc";
                    break;
                case "5":
                    $this->_sort = " order by price desc";
                    break;
                default:
                    $this->_sort = " order by price";
            }

            if (isset($_POST['category'])) {
                $this->_category = $_POST['category'];
                //$category=urldecode($category);
            } else {
                $this->_category = null;
            }

            $products = $this->products_model->get($this->_category, $this->_sort);

            $images = $this->images_model->get($this->_category);

            $main_images = $this->images_model->get_main($this->_category);
            $rating = $this->products_model->getRating();

            echo json_encode([
                'html' => $this->load->view('ajax/product_list',
                    ['products' => $products, 'images' => $images, 'main_images' => $main_images, 'rating' => $rating],
                    true),
                'success' => 1
            ]);

        }


    }
}
?>