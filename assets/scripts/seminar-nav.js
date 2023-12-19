activeSectionLinks();

function activeSectionLinks() {
   const sections = document.querySelectorAll('[id*=section]');
   const allSectionNavlinks = document.querySelectorAll('.seminar-navbar a');

   sections.forEach(section => {
      const sectionCollapse = section.querySelector('.accordion-collapse');
      const sectionButton = section.querySelector('.accordion-button');
      const sectionNavlinks = document.querySelectorAll('[href="#' + section.id + '"]');
      const otherNavlinks = (Array.from(allSectionNavlinks)).filter(link => link != sectionNavlinks[0] && link != sectionNavlinks[1]);
      function toggleActive() {
         if (sectionCollapse.classList.value.includes('show')) {
            sectionNavlinks.forEach(sectionNavlink => {
               sectionNavlink.classList.add('active');
            })
            otherNavlinks.forEach(sectionNavlink => {
               sectionNavlink.classList.remove('active');
            })
         }
      }
      toggleActive();
      sectionButton.addEventListener('click', (e) => {
         setTimeout(() => {
            toggleActive();
         }, 400);
      })
   })

   allSectionNavlinks.forEach(link => {
      const otherLinks = Array.from(allSectionNavlinks).filter(otherLink => otherLink != link);
      link.addEventListener('click', (e) => {
         link.classList.add('active');
         otherLinks.forEach(otherLink => {
            otherLink.classList.remove('active');
         })
      })
   })
}
