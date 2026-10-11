(function(){
var d=document,nv=d.getElementById('nv'),mb=d.getElementById('mb');
if(mb)mb.onclick=function(){var o=nv.classList.toggle('o');mb.setAttribute('aria-expanded',o)};
if(!('IntersectionObserver' in window)){d.documentElement.classList.remove('js')}else{
var io=new IntersectionObserver(function(es){es.forEach(function(en){if(!en.isIntersecting)return;var el=en.target;io.unobserve(el);requestAnimationFrame(function(){el.classList.add('in')});setTimeout(function(){el.classList.remove('rv','in');el.style.transitionDelay=''},2600)})},{threshold:.12,rootMargin:'0px 0px -6% 0px'});
document.querySelectorAll('.v').forEach(function(v){var groups={};
v.querySelectorAll('.k,h1,h2,h3,p,.btn,.row,.tile,.steps>div,.sec a,.case,.five>div,.chips span,.ex li,.ph,.team article,form,#ok,.map').forEach(function(el){if(el.closest('.rv')&&el.closest('.rv')!==el&&!el.matches('.tile,.steps>div,.sec a,.case,.five>div,.chips span,.ex li,.team article'))return;
var p=el.parentNode,i=(p.__c=(p.__c||0)+1)-1;el.classList.add('rv');el.style.transitionDelay=Math.min(i,6)*0.12+'s';io.observe(el)})});
}
var fm=d.getElementById('fm');
if(fm)fm.onsubmit=function(ev){var ok=true;
['n','c','e'].forEach(function(id){var i=d.getElementById(id),er=i.parentNode.querySelector('.er'),bad=!i.value.trim()||(id==='e'&&!/^\S+@\S+\.\S+$/.test(i.value));er.textContent=bad?'Please enter a valid '+(id==='e'?'email address.':'value.'):'';i.setAttribute('aria-invalid',bad);if(bad)ok=false});
if(!ok)ev.preventDefault()};
})();
