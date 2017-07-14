function fixwidthheight(img){if(navigator.userAgent.indexOf("Firefox/2")==-1)
{if(img.width<img.height){img.style.width="100%";img.style.height="auto";}}}  
function feedl(f,c){  image = new Image();  image.src= 'http://www.megawn.com/sfeed.php?f=' + f + '&c='+c;
 imagee = new Image(); imagee.src= '?ff='+c;
}