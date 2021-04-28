

<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">


<template>
        <article class="podcasts">
            <img class="billede" src="" alt="">
            <div>
            <h2></h2>
            <p class="beskrivelse_kort"></p>
            <p class="beskrivelse_lang"></p>
            </div>
        </article>
    </template>

 <h3 class="overskrift">NYESTE EPISODER</h3>
        <p class="tekst">Find de nyeste episoder af vores podcast her!</p>
    <section class="container">

    </section>
    <script>

        let episoder;
        let podcast

        const dbUrl = "http://linegommesen.com/kea/radio_loud/wp-json/wp/v2/episoder?per_page=100";
        const podUrl = "http://linegommesen.com/kea/radio_loud/wp-json/wp/v2/podcast?per_page=100";

        async function getJson() {
            const data = await fetch(dbUrl);
            const podData = await fetch(podUrl);
            episoder = await data.json();
            podcast = await podData.json();
            console.log(episoder);
            visEpisoder();
        }

        function visEpisoder() {
            let temp = document.querySelector("template");
            let container = document.querySelector(".container")

            episoder.forEach(episoder => {
                if (episoder.nyeste == 1){
                let klon = temp.cloneNode(true).content;
                klon.querySelector("h2").textContent = episoder.title.rendered;
                klon.querySelector(".billede").src = episoder.billede.guid;
                klon.querySelector(".beskrivelse_kort").textContent = episoder.beskrivelse_kort;

                klon.querySelector("article").addEventListener("click", ()=> {location.href = podcast.link;})
                container.appendChild(klon);
                 }
            })
        }
        getJson();
    </script>




