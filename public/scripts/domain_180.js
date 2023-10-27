
                  var _gaq=[['_setAccount','UA-93479376-1'],['_trackPageview']];
                    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
                    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
                    s.parentNode.insertBefore(g,s)}(document,'script'));
                    
                  window.monetizerads = {


                      interstitial: function (){
                        
                        var target = document.getElementsByTagName('head')[0];
                        var Interstitial = document.createElement('script');
                            Interstitial.append('window.googletag = window.googletag || {cmd: []};');
                            Interstitial.append('googletag.cmd.push(function() {');
                            Interstitial.append("var slot = googletag.defineOutOfPageSlot('/22013536576/welteodoro.com/Welteodoro_WEB_Interstitial_Content_20201118', googletag.enums.OutOfPageFormat.INTERSTITIAL);");
                            Interstitial.append('if (slot) slot.addService(googletag.pubads());');
                            Interstitial.append('googletag.enableServices();');
                            Interstitial.append('googletag.display(slot);');
                            Interstitial.append('});');
                        
                        target.insertBefore(Interstitial, target.firstChild);
                        
                      
                      },
                      load_gtp: function (){
                        

                        var gads = document.createElement('script');
                            gads.async = true;
                            gads.type = 'text/javascript';
                            gads.src = 'https://www.googletagservices.com/tag/js/gpt.js';
                        
                        var target = document.getElementsByTagName('head')[0];
                            
                            target.insertBefore(gads, target.firstChild);
                      },

                      isMob: function(){
                          if (sessionStorage.desktop){
                              return false;
                            } else if (localStorage.mobile){
                              return true;
                            }            
                            var mobile = ['iphone', 'ipad', 'android', 'blackberry', 'nokia', 'opera mini', 'windows mobile', 'windows phone', 'iemobile', 'tablet', 'mobi'];
                            var ua = navigator.userAgent.toLowerCase();
                            for (var i in mobile)
                                if (ua.indexOf(mobile[i]) > -1) return true;
                            return false;
                      },
                      
                      agora: function (blocos){          
                            
                          window.monetizerads.generateCSS();
                            
                            window.monetizerads.load_gtp();

                            var target = document.getElementsByTagName('body')[0];
                            blocos.forEach(function(a,b){
                              if(window.monetizerads.isMob()){
                                  if(a.mobile > 0){
                                      target.appendChild(window.monetizerads.generateBlock(a.bloco,a.div,a.className,a.size));
                                  }
                              } else {
                                  if(a.mobile < 1){
                                      target.appendChild(window.monetizerads.generateBlock(a.bloco,a.div,a.className,a.size));
                                  }
                              }
                              
                            })
                      },
                    
                      generateBlock: function(slot,id,className,size){
                        var divBlock = document.createElement("div");
                            divBlock.className = className;  
                            
                        var preTag = document.createElement("script");
                            preTag.append('window.googletag = window.googletag || {cmd: []};');
                            preTag.append('var bloco_'+id+' = googletag.cmd.push(function() {');
                            preTag.append('googletag.defineSlot("'+slot+'", ['+size+'], "'+id+'").setCollapseEmptyDiv(true).addService(googletag.pubads());');
                            preTag.append('googletag.enableServices();');
                            preTag.append('});');
                    
                            divBlock.appendChild(preTag);
                    
                    
                        var posTag = document.createElement("script");
                            posTag.append('googletag.cmd.push(function() { googletag.display("'+id+'"); });');
                    
                        var subDivBlock = document.createElement("div");
                            subDivBlock.id = id;
                            subDivBlock.appendChild(posTag);
                    
                            divBlock.appendChild(subDivBlock);  
                            return divBlock;
                      },

                      generateCSS: function(){
                          var cssLoad = document.createElement('style');
                              cssLoad.append('.ad-fixed-top{position:fixed;z-index:9995;top:0;text-align:center;left:50%!important;transform:translate(-50%);}.ad-fixed-bottom{position:fixed;z-index:9995;bottom:0;text-align:center;left:50%;transform:translate(-50%);}.ad-fixed-left{position:fixed;z-index:9995;left:0;text-align:center;top:50%;transform:translateY(-50%);}.ad-fixed-right{position:fixed;z-index:9995;right:0;text-align:center;top:50%;transform:translateY(-50%);}');
                              var target = document.getElementsByTagName('head')[0];
                              target.insertBefore(cssLoad, target.firstChild);
                      },
                      refresh: function(){
                        googletag.pubads().refresh();
                        setTimeout(function() { 
                          window.monetizerads.refresh();
                          console.debug('refresh');
                         }, 30 * 1000);
                      }
                    
                    };

      var blocos =[{"bloco":"\/22013536576\/welteodoro.com\/Welteodoro_MOBILE_Horizontal_Fixed1_Content_20201118","div":"MfixedBottom","className":"ad-fixed-bottom","size":"[320, 50]","mobile":1},{"bloco":"\/22013536576\/welteodoro.com\/Welteodoro_MOBILE_Horizontal_Fixed_Content_20201118","div":"MfixedTop","className":"ad-fixed-top","size":"[320, 50]","mobile":1},{"bloco":"\/22013536576\/welteodoro.com\/Welteodoro_WEB_Vertical_Sidebar1_Content_20201118","div":"fixedLeft","className":"ad-fixed-left","size":"[120, 600], [160, 600]","mobile":0},{"bloco":"\/22013536576\/welteodoro.com\/Welteodoro_WEB_Horizontal_TopFixed1_Content_20201118","div":"fixedBottom","className":"ad-fixed-bottom","size":"[960, 90], [980, 120], [970, 90], [728, 90], [750, 100], [950, 90], [980, 90], [970, 66]","mobile":0},{"bloco":"\/22013536576\/welteodoro.com\/Welteodoro_WEB_Vertical_Sidebar_Content_20201118","div":"fixedRight","className":"ad-fixed-right","size":"[120, 600], [160, 600]","mobile":0},{"bloco":"\/22013536576\/welteodoro.com\/Welteodoro_WEB_Horizontal_TopFixed_Content_20201118","div":"fixedTop","className":"ad-fixed-top","size":"[960, 90], [980, 120], [970, 90], [728, 90], [750, 100], [950, 90], [980, 90], [970, 66]","mobile":0}];window.onload = window.monetizerads.agora(blocos);;;console.debug('START ADS');