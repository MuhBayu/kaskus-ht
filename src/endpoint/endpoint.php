<?php

namespace MuhBayu\KaskusHT\Traits;
trait EndPoint
{
	/**
	 * @return hotthread with default page is 1
	 */
	public function hotthread($page='1') {
		if($cache = $this->cache->read("kaskusht-page$page")) {
			$this->output = $cache;
			return $this;
		} 
		$data = $this->cUrl($this->uri_kaskus_source);
		$html = str_get_html($data);
		$total_page = $html->find('span[class=pagination-page-count]', 0)->plaintext;
		$output['success'] 			= true;
		$output['load_time'] 		= 0;
		$output['page']				= 1;
		$output['total_pages']		= explode(' ', $total_page)[3];
		if($page == NULL || $page == 1) {
			$position = 2;
			$star_trit 	 	=  $html->find('div[class=list-star hot-thread]', 0);
			$star_title  	=  $star_trit->find('span[class=hot-thread-title]', 0);
			$star_link		=  $star_trit->find('div[class=detail] a',3)->href;
			$star_detail 	=  $star_trit->find('div[class=detail]',0);
			$star_img	 	=  $star_trit->find('div[class=hot-thread-image] img', 0)->attr['data-src'];
			$star_img    	=  str_replace('r480x480', 'r720x720', $star_img);
			$star_user   	=  $star_detail->find('a', 1);
			$star_user_ava 	=  $star_trit->find('span[class=user-photo] a img', 0)->attr['data-src'];
			$star_meta   	=  $star_trit->find('div[class=sub-meta]',0);
			$star_analytic 	=  $star_meta->find('div[class=analytic] a', 1)->plaintext;
			$star_reply 	=  $star_meta->find('div[class=analytic] a', 0)->plaintext;
			$star = array(
				'position' => 1,
				'top_star' => true,
				'rating' => trim($star_analytic),
				'reply' => trim($star_reply),
				'title' => trim($star_title->plaintext),
				'detail' => trim($star_detail->find('p', 0)->plaintext),
				'link' => $this->uri_kaskus . $star_link,
				'img' => $star_img,
				'user' => array(
					'id' => $star_user->plaintext,
					'profile' => $this->uri_kaskus . $star_user->href,
					'avatar' => $star_user_ava
				),
				'forum' => array(
					'name' => $star_meta->find('a', 0)->plaintext,
					'link' => $this->uri_kaskus . $star_meta->find('a', 0)->href
				)
			);
		} else {
			$output['page'] = $page;
			$position = 1;
		}
		$hot_trit = $html->find('div[class=list-today hot-thread]');
		foreach ($hot_trit as $key => $value) {
			if ($key >= 12) break;
			$trit_title  	=  $value->find('span[class=hot-thread-title]', 0)->plaintext;
			$trit_link 		=  $this->uri_kaskus . $value->find('div[class=hot-thread-image] a',0)->href;
			$trit_detail 	=  $value->find('div[class=detail]',0);
			$trit_img 	 	=  $value->find('div[class=hot-thread-image] a img', 0)->attr['data-src'];
			$trit_img    	=  str_replace('r150x200', 'r720x720', $trit_img);
			$trit_user   	=  $value->find('span a', 1);
			$trit_user_ava  =  $value->find('span[class=user-photo] a img', 0)->attr['data-src'];
			$trit_meta   	=  $value->find('div[class=sub-meta]',0);
			$trit_analytic 	=  $trit_meta->find('div[class=analytic] a', 1)->plaintext;
			$trit_reply 	=  $trit_meta->find('div[class=analytic] a', 0)->plaintext;
			$output['hot_threads'][] = array(
				"position" => $position++,
				'rating' => trim($trit_analytic),
				'reply' => trim($trit_reply),
				"title" => trim($trit_title),
				'detail' => trim($trit_detail->find('p', 0)->plaintext),
				"link" => $trit_link,
				"img"  => $trit_img,
				"user" => array(
					'id' => $trit_user->plaintext,
					'profile' => $this->uri_kaskus . $trit_user->href,
					'avatar' => $trit_user_ava
				),
				'forum' => array(
					'name' => $trit_meta->find('a', 0)->plaintext,
					'link' => $this->uri_kaskus . $trit_meta->find('a', 0)->href
				)
			);
		}
		$endScriptTime		 =	microtime(TRUE);
		$output['load_time'] =  round(($endScriptTime - $this->startScriptTime), 4);
		if($page == NULL || $page == 1) {
			array_unshift($output['hot_threads'],$star);
		}
		$this->output = $output;
		$this->cache->save("kaskusht-page$page", $output);
		return $this;
	}
}	