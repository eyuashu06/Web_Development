function scrollToSection(id){
document.getElementById(id).scrollIntoView({behavior:"smooth"});
}

/* section animation */
const sections=document.querySelectorAll(".page-section");
const observer=new IntersectionObserver(entries=>{
entries.forEach(e=>{
if(e.isIntersecting){
e.target.classList.add("show");

/* animate skill bars */
if(e.target.id==="skills"){
document.querySelectorAll(".bar span").forEach(s=>{
s.style.width=s.dataset.level+"%";
});
}
}
});
},{threshold:.3});
sections.forEach(s=>observer.observe(s));
// Animate skill bars on scroll
const skillsSection = document.getElementById("skills");
const skillBars = document.querySelectorAll(".bar span");

const skillsObserver = new IntersectionObserver(entries=>{
  entries.forEach(entry=>{
    if(entry.isIntersecting){
      skillBars.forEach(s => s.style.width = s.dataset.level);
    }
  });
},{threshold:0.5});

skillsObserver.observe(skillsSection);
