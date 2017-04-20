<?php
class Pagination
{
  private $page;
  private $total_pages;
  private $num_links;
  private $css_class;
  private $pagevar;
  private $uri;

  public function __construct($current_page, $total_pages, $num_links=10, $css_class=NULL, $pagevar='p', $uri=NULL)
  {
    $this->page = $current_page;
    $this->total_pages = $total_pages;
    $this->num_links = $num_links;
    $this->css_class = $css_class;
    $this->pagevar = $pagevar;
    $this->uri = isset($uri) ? $uri : $_SERVER['REQUEST_URI'];
  }

  private function getCleanUri()
  {
    $uri = preg_replace('/[\?&]' . $this->pagevar . '=\d*/', '', $this->uri);
    return (strpos($uri, '?') === false) ? $uri . '?' . $this->pagevar . '=' : $uri . '&' . $this->pagevar . '=';
  }

  public function setUri($uri)
  {
    $this->uri = $uri;
  }

  public function getPages($show_previous_next=true, $show_first_last=true, $show_arrow_text=true, $hashtag='')
  {
    if ($this->total_pages == 1)
    {
      return '';
    }

    $paging_uri = $this->getCleanUri();
    $paging_end = $this->page + ceil($this->num_links / 2) - 1;

    if ($paging_end > $this->total_pages)
    {
      $paging_end = $this->total_pages;
    }

    if ($paging_end - $this->num_links > 0)
    {
      $paging_start = $paging_end - $this->num_links + 1;
    }
    else
    {
      $paging_start = 1;
      $paging_end  += $this->num_links - $paging_end;

      if ($paging_end > $this->total_pages)
      {
        $paging_end = $this->total_pages;
      }
    }

    $output = '<ul class="pagination"' . (isset($this->css_class) ? ' class="' . $this->css_class . '"' : '') . '>';


    $classTxt = ($this->page == 1) ? 'disabled' : '';
    $output .= '<li class="'.$classTxt.'"><a href="' . $paging_uri . '1' .$hashtag. '" title="Go to the first page">&laquo;' . ($show_arrow_text ? ' First' : '') . '</a></li>';
    $output .= '<li class="'.$classTxt.'"><a href="' . $paging_uri . ($this->page - 1)  .$hashtag.  '" title="Go to the previous page">&lsaquo;' . ($show_arrow_text ? ' Prev' : '') . '</a></li>';


    for ($i=$paging_start; $i<=$paging_end; $i++)
    {
      if ($this->page == $i)
      {
        $output .= '<li class="active"><a>' . $i . '</a></li>';
      }
      else
      {
        $output .= '<li><a href="' . $paging_uri . $i  .$hashtag.  '" title="Go to page ' . $i . '">' . $i . '</a></li>';
      }
    }

    $classTxt = ($this->page == $this->total_pages) ? 'disabled' : '';
    $output .= '<li class="'.$classTxt.'"><a href="' . $paging_uri . ($this->page + 1)  .$hashtag.  '" title="Go to the next page">' . ($show_arrow_text ? 'Next ' : '') . '&rsaquo;</a></li>';
    $output .= '<li class="'.$classTxt.'"><a href="' . $paging_uri . $this->total_pages  .$hashtag.  '" title="Go to the last page">' . ($show_arrow_text ? 'Last ' : '') . '&raquo;</a></li>';

    $output .= '</ul>';

    return $output;
  }
}
?>