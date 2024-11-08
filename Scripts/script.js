document.addEventListener("DOMContentLoaded", function () {
    const carousel = document.querySelector(".carousel");
    const dotsContainer = document.querySelector(".dots");
    
    if (carousel) {
        const images = carousel.querySelectorAll("img");
        const firstImg = images[0];
        const arrowIcons = document.querySelectorAll(".wrapper i");

        let isDragStart = false, isDragging = false, prevPageX, prevScrollLeft, positionDiff;
        

        images.forEach((img, index) => {
            const dot = document.createElement("span");
            dot.classList.add("dot");
            if (index === 0) dot.classList.add("active"); 
            dot.dataset.index = index; 
            dotsContainer.appendChild(dot);


            dot.addEventListener("click", function () {
                carousel.scrollLeft = index * (firstImg.clientWidth + 14);
                updateActiveDot(index);
                showHideIcons();
            });
        });

        const showHideIcons = () => {
            let scrollWidth = carousel.scrollWidth - carousel.clientWidth;
            arrowIcons[0].style.display = carousel.scrollLeft === 0 ? "none" : "block";
            arrowIcons[1].style.display = carousel.scrollLeft === scrollWidth ? "none" : "block";
        };

        const updateActiveDot = (activeIndex) => {
            document.querySelectorAll(".dots .dot").forEach((dot, index) => {
                dot.classList.toggle("active", index === activeIndex);
            });
        };

        arrowIcons.forEach(icon => {
            icon.addEventListener("click", () => {
                let firstImgWidth = firstImg.clientWidth + 14;
                let direction = icon.id === "left" ? -1 : 1;
                carousel.scrollLeft += direction * firstImgWidth;
                setTimeout(() => {
                    let activeIndex = Math.round(carousel.scrollLeft / firstImgWidth);
                    updateActiveDot(activeIndex);
                    showHideIcons();
                }, 60);
            });
        });

        const autoSlide = () => {
            if (carousel.scrollLeft - (carousel.scrollWidth - carousel.clientWidth) > -1 || carousel.scrollLeft <= 0) return;
            positionDiff = Math.abs(positionDiff);
            let firstImgWidth = firstImg.clientWidth + 14;
            let valDifference = firstImgWidth - positionDiff;

            if (carousel.scrollLeft > prevScrollLeft) {
                carousel.scrollLeft += positionDiff > firstImgWidth / 3 ? valDifference : -positionDiff;
            } else {
                carousel.scrollLeft -= positionDiff > firstImgWidth / 3 ? valDifference : -positionDiff;
            }

            let activeIndex = Math.round(carousel.scrollLeft / firstImgWidth);
            updateActiveDot(activeIndex);
        };

        const dragStart = (e) => {
            isDragStart = true;
            prevPageX = e.pageX || e.touches[0].pageX;
            prevScrollLeft = carousel.scrollLeft;
        };

        const dragging = (e) => {
            if (!isDragStart) return;
            e.preventDefault();
            isDragging = true;
            carousel.classList.add("dragging");
            positionDiff = (e.pageX || e.touches[0].pageX) - prevPageX;
            carousel.scrollLeft = prevScrollLeft - positionDiff;
            showHideIcons();
        };

        const dragStop = () => {
            isDragStart = false;
            carousel.classList.remove("dragging");
            if (!isDragging) return;
            isDragging = false;
            autoSlide();
        };

        carousel.addEventListener("mousedown", dragStart);
        carousel.addEventListener("touchstart", dragStart);
        document.addEventListener("mousemove", dragging);
        carousel.addEventListener("touchmove", dragging);
        document.addEventListener("mouseup", dragStop);
        carousel.addEventListener("touchend", dragStop);

        // Show or hide icons on page load
        showHideIcons();
    } else {
        console.error("Carousel element not found");
    }
});

const toggleButtons = document.querySelectorAll('.round-red');


$(function(){
    $(window).scroll(function(){
      var winTop = $(window).scrollTop();
      if(winTop >= 30){
        $("body").addClass("sticky-header");
      }else{
        $("body").removeClass("sticky-header");
      }//if-else
    });//win func.
  });//ready func.

