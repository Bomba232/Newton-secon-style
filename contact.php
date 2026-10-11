<?php
require __DIR__.'/config.php';
function h($s){return htmlspecialchars((string)$s,ENT_QUOTES,'UTF-8');}
function v($k){return h($_POST[$k]??'');}
function make_token(){$t=time();return $t.'.'.hash_hmac('sha256',(string)$t,FORM_SECRET);}
function token_age($tok){$p=explode('.',(string)$tok);if(count($p)!==2)return false;if(!hash_equals(hash_hmac('sha256',$p[0],FORM_SECRET),$p[1]))return false;return time()-(int)$p[0];}
function clean($s){return trim(preg_replace('/[\r\n]+/',' ',(string)$s));}
$errors=[];$sent=isset($_GET['sent']);
$interests=['Market Entry','Business Development','Strategic Partnerships','Investment Opportunities','Technology & Innovation','Other'];
if($_SERVER['REQUEST_METHOD']==='POST'){
  if(!empty($_POST['website'])){header('Location: contact.php?sent=1');exit;} // honeypot: bots only
  $age=token_age($_POST['ts']??'');
  if($age===false||$age<3||$age>7200)$errors[]='Please try again.';
  $name=clean($_POST['name']??'');$company=clean($_POST['company']??'');$email=clean($_POST['email']??'');
  $phone=clean($_POST['phone']??'');$country=clean($_POST['country']??'');$interest=clean($_POST['interest']??'');
  $message=trim((string)($_POST['message']??''));
  if($name===''||mb_strlen($name)>120)$errors[]='Please enter your name.';
  if($company===''||mb_strlen($company)>160)$errors[]='Please enter your company.';
  if(!filter_var($email,FILTER_VALIDATE_EMAIL)||mb_strlen($email)>200)$errors[]='Please enter a valid email address.';
  if(mb_strlen($phone)>40||mb_strlen($country)>80||mb_strlen($message)>5000)$errors[]='One of the fields is too long.';
  if(!in_array($interest,$interests,true))$interest='Other';
  if(!$errors){
    $subject='=?UTF-8?B?'.base64_encode('Website enquiry - '.$company).'?=';
    $body="Name: $name\nCompany: $company\nEmail: $email\nTelephone: $phone\nCountry: $country\nArea of interest: $interest\n\n$message\n";
    $headers='From: Newton Website <'.MAIL_FROM."> \r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8";
    if(mail(MAIL_TO,$subject,$body,$headers)){header('Location: contact.php?sent=1');exit;}
    $errors[]='Sorry, your message could not be sent. Please email info@newtonincorp.com directly.';
  }
}
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>Contact — Newton Incorporation</title>
<meta name="description" content="Start a conversation with Newton Incorporation.">
<link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E🧭%3C/text%3E%3C/svg%3E">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fraunces:wght@400;500&family=Inter:wght@400;500;600&display=swap">
<link rel="stylesheet" href="assets/style.css">
<script>document.documentElement.classList.add('js')</script>
</head><body>
<header><div class="w"><a class="logo" href="index.html">NEWTON</a><button id="mb" aria-expanded="false" aria-controls="nv">MENU</button>
<nav id="nv" aria-label="Main"><a href="index.html">HOME</a><a href="about.html">ABOUT</a><a href="expertise.html">EXPERTISE</a><a href="sectors.html">SECTORS</a><a href="team.html">TEAM</a><a href="contact.php" class="on">CONTACT</a><a class="btn" href="contact.php">START A CONVERSATION →</a></nav></div></header>
<main><div class="v on" id="v-contact">
<section class="hero sm"><div class="w"><h1>Start a Conversation.</h1><p>International opportunities often begin with a simple conversation. Tell us what market you are exploring, the opportunity you are developing or the organisations you would like to reach.</p></div></section><section class="s"><div class="w split ct" style="align-items:start"><div><h3>Newton Incorporation Ltd</h3><p style="color:var(--mut)">Units E-H, 15/F, TAL Building,<br>49 Austin Road, Kowloon,<br>Hong Kong<br><br><a href="mailto:info@newtonincorp.com">info@newtonincorp.com</a></p></div><div><?php if($sent): ?><div id="ok" role="status" style="display:block"><h3>Thank you.</h3><p style="margin:0">Your enquiry has been sent. We will be in touch shortly.</p></div><?php else: ?><?php if($errors): ?><div class="er" role="alert" style="font-size:.95rem;margin-bottom:14px"><?= implode('<br>',array_map('h',$errors)) ?></div><?php endif; ?><form id="fm" method="post" action="contact.php" novalidate><div><label for="n">Name *</label><input id="n" name="name" value="<?= v('name') ?>" required autocomplete="name"><div class="er"></div></div><div><label for="c">Company *</label><input id="c" name="company" value="<?= v('company') ?>" required autocomplete="organization"><div class="er"></div></div><div><label for="e">Email *</label><input id="e" name="email" value="<?= v('email') ?>" type="email" required autocomplete="email"><div class="er"></div></div><div><label for="t">Telephone</label><input id="t" name="phone" value="<?= v('phone') ?>" type="tel" autocomplete="tel"></div><div><label for="co">Country</label><input id="co" name="country" value="<?= v('country') ?>" autocomplete="country-name"></div><div><label for="a">Area of interest</label><select id="a" name="interest"><option>Market Entry</option><option>Business Development</option><option>Strategic Partnerships</option><option>Investment Opportunities</option><option>Technology & Innovation</option><option>Other</option></select></div><div class="f"><label for="m">Tell us briefly about your opportunity</label><textarea id="m" name="message" rows="5"><?= v('message') ?></textarea></div><div class="hp" aria-hidden="true"><input id="hp" name="website" tabindex="-1" autocomplete="off"></div><input type="hidden" name="ts" value="<?= h(make_token()) ?>"><div class="f"><button class="btn" type="submit" style="color:#0b1b30">SEND ENQUIRY</button></div></form><?php endif; ?></div></div></section><section class="s dk"><div class="w"><h2>Let's Explore the Opportunity.</h2><p style="color:#c9d4e6">Whether you are entering a new market, seeking customers or partners, looking for investment or developing an international opportunity, Newton can help identify the organisations and people that matter.</p><span class="k" style="margin:0">Newton Incorporation — Connecting Opportunity. Accelerating Growth.</span></div></section>
</div></main>
<footer><div class="w fd"><div><b style="color:#fff;letter-spacing:.14em">NEWTON INCORPORATION LTD</b><br>Units E-H, 15/F, TAL Building, 49 Austin Road, Kowloon, Hong Kong<br><a href="mailto:info@newtonincorp.com">info@newtonincorp.com</a></div><div>Connecting Opportunity. Accelerating Growth.<br>© 2026 Newton Incorporation Limited</div></div></footer>
<script src="assets/main.js"></script>
</body></html>
