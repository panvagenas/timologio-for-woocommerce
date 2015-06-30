<?php
/*                                                                                      a
                                                                                       aaa
                                                                                      aaaaa
                                                              hhhh        hhhh       aaa aaa        rrrrrrrr
                                                  sssssss     hhhh        hhhh      aaaa aaaa      rrrrrrrrrrr    kkkk
www        w        ww eeeeeeeee  bbbbbbbb      sssssssssss   hhhh        hhhh     aaaa   aaaa     rrrr   rrrrr   kkkk     kkk      ssss
 www      www      www eeeeeeeee  bbbbbbbbb    sssss    sss   hhhh        hhhh    aaaaa   aaaaa    rrrr   rrrrr   kkkk   kkkkk   sssssssss
  www    wwwww    www  eee        bbb   bbb     sssss         hhhhhhhhhhhhhhhh   aaaaa     aaaaa   rrrrrrrrrr     kkkk  kkkk     ssss  sss
   www  www www  www   eeeeeeeee  bbbbbbbb       ssssssss     hhhhhhhhhhhhhhhh  aaaaaaaaaaaaaaaaa  rrrrrrrr       kkkkkkkkk      sssss
    www ww   ww www    eeeeeeeee  bbbbbbbbbb        sssssss   hhhh        hhhh aaaaaaaaaaaaaaaaaaa rrrrrrrrr      kkkkkkkk        ssssssss
     wwww     wwww     eee        bbb    bbb            ssss  hhhh        hhhh aaaaa         aaaaa rrrr  rrrr     kkkk kkkkk          sssss
      ww       ww      eeeeeeeee  bbbbbbbbbb   ssss     ssss  hhhh        hhhh aaaa           aaaa rrrr   rrrrr   kkkk  kkkkk   sss     sss
      ww       ww      eeeeeeeee  bbbbbbbb     sssssssssssss  hhhh        hhhh aaa             aaa rrrr    rrrrr  kkkk    kkkkk sssssssssss
                                                 ssssssss     hhhh        hhhh aa               aa rrrr      rrrr kkkk     kkkk   sssssss
     wswswswswswswswswswswswswswswswswsws                                                                                               ®*/

/**
 * XDaRk Core (WP plugin).
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com XDaRk}
 *
 * @author JasWSInc
 * @package XDaRk\Core
 * @since 130310
 */

if(!defined('WPINC'))
	exit('Do NOT access this file directly: '.basename(__FILE__));

/*
 * Load dependency utilities.
 */
$GLOBALS['autoload_xd_v141226_dev'] = FALSE;
require_once dirname(__FILE__).'/stub.php';
require_once xd_v141226_dev::deps();

/*
 * Check dependencies (and load framework; if possible).
 */
if(deps_xd_v141226_dev::check(xd_v141226_dev::$core_name, dirname(__FILE__)) === TRUE)
	require_once xd_v141226_dev::framework();