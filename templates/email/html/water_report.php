<?php 
 $distFirstName = explode(" ", $distributorName)[0];
?>
<div style="padding:0px 20px 20px 0px">
    <em style="font-style:normal;border-bottom:1px dotted;font-size:1em;color:#000000;">
        Hi <?= $contactFirstName ?>,
    </em>
   <p style="font-size:1em;margin-top:15px;color:#000000;">My name is <?= $distFirstName; ?> and I'm your personal water guide that Kevin mentioned in the video you just saw.</p>

<p style="font-size:1em;margin-top:15px;color:#000000;">Well done on taking the time to learn about the quality of your water and any hidden dangers you may be unaware of.</p>

<p style="font-size:1em;margin-top:15px;color:#000000;">As a bonus, we’ve included your instant water analysis resource in an easy to read safe water manual called, you guessed it, “The Safe Water Manual”. This manual has even more information on water health & safety.</p>

<p style="font-size:1em;margin-top:15px;color:#000000;">The instant analysis can be found in the “What’s in Your Water” section of the manual.</p>

<p style="font-size:1em;margin-top:15px;color:#000000;">You can download the manual <a href="https://getechoh2.com/water-guide.php">here</a>.</p>

<p style="font-size:1em;margin-top:15px;color:#000000;">I want to let you know that I have been where you are now and can help you with solutions if you find that your water is unsafe or at least not delivering the health benefits you expect from drinking water.</p>

<p style="font-size:1em;margin-top:15px;color:#000000;">I'll be reaching out to you shortly to find out what your current water situation is, what you'd like to do about it and what can be done to help.</p>

<p style="font-size:1em;margin-top:15px;color:#000000;">I can also answer any questions you have and I'd be happy to share my own water story with you if you'd like to hear it.</p>

<p style="font-size:1em;margin-top:15px;color:#000000;">You should get started now by downloading your Safe Water Manual at the link below. Then do the instant water analysis right away. It takes less than 60 seconds!</p>

<p style="font-size:1em;margin-top:15px;color:#000000;"><a href="https://getechoh2.com/water-guide.php">Download Your Safe Water Manual Here</a></p>

<p style="font-size:1em;margin-top:15px;color:#000000;">Thanks again and please be on the lookout for my call.</p>
</div>
<div style="padding:0px 20px 10px 0px">
    <p style="padding:0px;color:#000000; font-size:1em;">
        Thanks,<br/>
        <?= $distributorName ?><br/>
        <?= empty($distributorPhone) ? "" : $distributorPhone;  ?><br />
        The NuLife EchoH2 Team
    </p>
</div>