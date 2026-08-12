(() => {

let slides = document.querySelector(".Slider-Right-inner");

let temp = 1;

if(slides){

    setInterval(function () {

        slides.style.left = `-${100 * temp}%`;

        temp++;

        if(temp === 3){
            temp = 0;
        }

    }, 4000);

}

})();



document.addEventListener("DOMContentLoaded", function () {

    // CATALOGUE

    const catalogueData = [

        { btn: "btn1", gal: "gallery1" },
        { btn: "btn2", gal: "gallery2" },
        { btn: "btn3", gal: "gallery3" },
        { btn: "btn4", gal: "gallery4" },
        { btn: "btn5", gal: "gallery5" }

    ];



    // NEW COLLECTION

    const collectionData = [

        { btn: "btn6", gal: "gallery6" },
        { btn: "btn7", gal: "gallery7" },
        { btn: "btn8", gal: "gallery8" }

    ];





    function filterItems(data, allGalleries) {

        if (!Array.isArray(data)) {

            console.error("Data is not array");

            return;

        }



        data.forEach(item => {

            let button =
            document.getElementById(item.btn);

            let gallery =
            document.getElementById(item.gal);



            // if button/gallery not found skip

            if(button && gallery){

                button.addEventListener("click", function () {

                    // hide all galleries

                    allGalleries.forEach(id => {

                        let gal =
                        document.getElementById(id);

                        if(gal){

                            gal.classList.add("hidden");

                        }

                    });



                    // show selected gallery

                    gallery.classList.remove("hidden");



                    // remove active class

                    data.forEach(d => {

                        let btn =
                        document.getElementById(d.btn);

                        if(btn){

                            btn.classList.remove("active");

                        }

                    });



                    // active current button

                    this.classList.add("active");

                });

            }

        });

    }





    filterItems(

        catalogueData,

        [

            "gallery1",
            "gallery2",
            "gallery3",
            "gallery4",
            "gallery5"

        ]

    );





    filterItems(

        collectionData,

        [

            "gallery6",
            "gallery7",
            "gallery8"

        ]

    );

});