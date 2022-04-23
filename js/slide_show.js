			var slideIndex = [];
            var slideId = ["grantoppen-slide", "granbo-slide", "granstua-slide", "granhaug-slide"];
            showSlides(1, 0);
            showSlides(1, 1);
            showSlides(1, 2);
            showSlides(1, 3);

            function plusSlides(n, no) {
                showSlides(slideIndex[no] += n, no);
            }
            
            function showSlides(n, no) {
                var i;
                var x = document.getElementsByClassName(slideId[no]);
                if (typeof slideIndex[no] === 'undefined')
                    slideIndex[no] = 1;
                if (n > x.length)
                    slideIndex[no] = 1;
                if (n < 1)
                    slideIndex[no] = x.length;
                for (i = 0; i < x.length; i++)
                    x[i].style.display = "none";
                x[slideIndex[no]-1].style.display = "block";
            }