function showDetails(id) {
    
    let button = document.getElementById("showMoreButton"+id);
    let div = document.getElementById("showMore"+id);

    if (div.style.display == "none") {
        div.style.display = "block";
        button.innerText = "Schowaj";
    } else {
        div.style.display = "none";
        button.innerText = "Pokaż więcej";
    }
    return;
}

function showDailyChart(id) {

    let dailyDiv = document.getElementById("dailyChart"+id);
    let hourlyDiv = document.getElementById("hourlyChart"+id);
    let dailyRainDiv = document.getElementById("dailyRainChart"+id);
    let hourlyRainDiv = document.getElementById("hourlyRainChart"+id);

    if (dailyDiv.style.display == "none") {
        dailyDiv.style.display = "block";
        hourlyDiv.style.display = "none";
        dailyRainDiv.style.display = "none";
        hourlyRainDiv.style.display = "none";
    } 
    return;
}


function showHourlyChart(id) {

    let dailyDiv = document.getElementById("dailyChart"+id);
    let hourlyDiv = document.getElementById("hourlyChart"+id);
    let dailyRainDiv = document.getElementById("dailyRainChart"+id);
    let hourlyRainDiv = document.getElementById("hourlyRainChart"+id);

    if (hourlyDiv.style.display == "none") {
        hourlyDiv.style.display = "block";
        dailyDiv.style.display = "none";
        dailyRainDiv.style.display = "none";
        hourlyRainDiv.style.display = "none";
    } 
    return;
}

function showDailyRainChart(id) {

    let dailyDiv = document.getElementById("dailyChart"+id);
    let hourlyDiv = document.getElementById("hourlyChart"+id);
    let dailyRainDiv = document.getElementById("dailyRainChart"+id);
    let hourlyRainDiv = document.getElementById("hourlyRainChart"+id);

    if (dailyRainDiv.style.display == "none") {
        dailyRainDiv.style.display = "block";
        dailyDiv.style.display = "none";
        hourlyDiv.style.display = "none";
        hourlyRainDiv.style.display = "none";
    } 
    return;
}

function showHourlyRainChart(id) {

    let dailyDiv = document.getElementById("dailyChart"+id);
    let hourlyDiv = document.getElementById("hourlyChart"+id);
    let dailyRainDiv = document.getElementById("dailyRainChart"+id);
    let hourlyRainDiv = document.getElementById("hourlyRainChart"+id);

    if (hourlyRainDiv.style.display == "none") {
        hourlyRainDiv.style.display = "block";
        dailyDiv.style.display = "none";
        hourlyDiv.style.display = "none";
        dailyRainDiv.style.display = "none";
    } 
    return;
}

