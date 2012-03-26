<?php
global $si_contact_form;
?>

<div id="contact-form" class="col-full">
  <div id="inner-contact-form" class="col-left">
    <?php if (isset($si_contact_form)): ?>
      <?php echo $si_contact_form->si_contact_form_short_code(array('form' => '1')); ?>
    <?php endif; ?>
  </div>
  <div id="inner-contact-map" class="col-right">
    <p>VIENICI A TROVARE</p>
    <iframe width="410" height="270" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.it/maps?f=q&amp;source=s_q&amp;hl=it&amp;geocode=&amp;q=via+dello+scalo+21%2F3+bologna&amp;aq=&amp;sll=41.442726,12.392578&amp;sspn=18.100779,39.506836&amp;t=m&amp;ie=UTF8&amp;hq=&amp;hnear=Via+dello+Scalo,+21,+40131+Bologna,+Emilia+Romagna&amp;ll=44.502138,11.327763&amp;spn=0.033057,0.07021&amp;z=13&amp;iwloc=near&amp;output=embed"></iframe><br /><small><a href="http://maps.google.it/maps?f=q&amp;source=embed&amp;hl=it&amp;geocode=&amp;q=via+dello+scalo+21%2F3+bologna&amp;aq=&amp;sll=41.442726,12.392578&amp;sspn=18.100779,39.506836&amp;t=m&amp;ie=UTF8&amp;hq=&amp;hnear=Via+dello+Scalo,+21,+40131+Bologna,+Emilia+Romagna&amp;ll=44.502138,11.327763&amp;spn=0.033057,0.07021&amp;z=13&amp;&iwloc=A" style="color:#0000FF;text-align:left">Visualizzazione ingrandita della mappa</a></small>
    <div id="contact-address">
      <address id="sede-operativa">
        <p>Sede operativa</p>
        Via dello scalo 21/3 Bologna<br />
        <?php #email encodata generata con http://hivelogic.com/enkoder/index.php ?>
        <script type="text/javascript">
          //<![CDATA[
          <!--
          var x="function f(x){var i,o=\"\",l=x.length;for(i=0;i<l;i+=2) {if(i+1<l)o+=" +
            "x.charAt(i+1);try{o+=x.charAt(i);}catch(e){}}return o;}f(\"ufcnitnof x({)av" +
            " r,i=o\\\"\\\"o,=l.xelgnhtl,o=;lhwli(e.xhcraoCedtAl(1/)3=!84{)rt{y+xx=l;=+;" +
            "lc}tahce({)}}of(r=i-l;1>i0=i;--{)+ox=c.ahAr(t)i};erutnro s.buts(r,0lo;)f}\\" +
            "\"(0),3\\\"\\\\N;UFDY30\\\\0W\\\\3K00\\\\\\\\20\\\\0Z\\\\07\\\\07\\\\02\\\\" +
            "\\\\37\\\\0]\\\\32\\\\01\\\\00\\\\\\\\24\\\\0,\\\\04\\\\04\\\\01\\\\\\\\07\\"+
            "\\01\\\\00\\\\\\\\DYr9\\\\\\\\00\\\\03\\\\00\\\\\\\\25\\\\04\\\\02\\\\\\\\*" +
            ">3330\\\\0x\\\\05\\\\0e\\\\:2=!r'4s01\\\\\\\\+:8c$.=d?(05\\\\0+\\\\,%z(JPUQ" +
            "WZ33\\\\0d\\\\\\\\nP\\\\FP2[02\\\\\\\\4P01\\\\\\\\\\\\r6\\\\00\\\\\\\\@C^NZ" +
            "@0P01\\\\\\\\JQOFCTzp\\\"\\\\f(;} ornture;}))++(y)^(iAtdeCoarchx.e(odrChamC" +
            "ro.fngriSt+=;o27=1y%){++;i<l;i=0(ior;fthnglex.l=\\\\,\\\\\\\"=\\\",o iar{vy" +
            ")x,f(n ioctun\\\"f)\")"                                                      ;
          while(x=eval(x));
          //-->
          //]]>
        </script>
        <br />
        Tel. +39 340 56 17 769
      </address>
      
      <address id="sede-legale">
        <p>Sede legale</p>
        Via De' Carracci 69/6,<br />
        40129 Bologna<br />
        Tel. +39 333 68 46 684
      </address>
    </div>
  </div>
</div>
<div id="show-contact-form" class="col-full">
  <a class="col-full" rel="show-contact-form" href="#">CONTATTI</a>
</div>

<script type="text/javascript">
  (function ($) {
    $(document).ready(function() {
      if(window.location.hash === "#FSContact1" ) {
        $("#contact-form").show();
      }

      $('a[rel="show-contact-form"]').bind('click', function() {
        
        if ($("#contact-form").is(":hidden")) {
          $("#contact-form").slideDown("slow", function(){
            $('a[rel="show-contact-form"]').css('background', "url('<?php echo get_template_directory_uri();?>/images/arrow-contact-up.gif') #103457 no-repeat 80px 15px");
          });
          
        } else {
          $("#contact-form").slideUp("slow", function(){
            $('a[rel="show-contact-form"]').css('background', "url('<?php echo get_template_directory_uri();?>/images/arrow-contact-down.gif') #103457 no-repeat 80px 15px");
          });
        }
      });
    });
    
  })(jQuery);

</script>