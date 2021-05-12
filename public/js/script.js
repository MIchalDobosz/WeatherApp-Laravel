function showDetails($id) {
    
    let button = document.getElementById("showMoreButton"+$id);
    let div = document.getElementById("showMoreDiv"+$id);

    if (div.style.display == "none") {
        div.style.display = "block";
        button.innerText = "Schowaj";
    } else {
        div.style.display = "none";
        button.innerText = "Pokaż więcej";
    }
    return;
}

function showDailyForecastDay($id) {

    let dailyDayDiv = document.getElementById("dailyForecastDayDiv"+$id);
    let dailyNightDiv = document.getElementById("dailyForecastNightDiv"+$id);
    let hourlyDiv = document.getElementById("hourlyForecastDiv"+$id);

    if (dailyDayDiv.style.display == "none") {
        dailyDayDiv.style.display = "block";
        dailyNightDiv.style.display = "none";
        hourlyDiv.style.display = "none";
    } 
    return;
}

function showDailyForecastNight($id) {

    let dailyDayDiv = document.getElementById("dailyForecastDayDiv"+$id);
    let dailyNightDiv = document.getElementById("dailyForecastNightDiv"+$id);
    let hourlyDiv = document.getElementById("hourlyForecastDiv"+$id);

    if (dailyNightDiv.style.display == "none") {
        dailyNightDiv.style.display = "block";
        dailyDayDiv.style.display = "none";
        hourlyDiv.style.display = "none";
    } 
    return;
}

function showHourlyForecast($id) {

    let dailyDayDiv = document.getElementById("dailyForecastDayDiv"+$id);
    let dailyNightDiv = document.getElementById("dailyForecastNightDiv"+$id);
    let hourlyDiv = document.getElementById("hourlyForecastDiv"+$id);

    if (hourlyDiv.style.display == "none") {
        hourlyDiv.style.display = "block";
        dailyDayDiv.style.display = "none";
        dailyNightDiv.style.display = "none";
    } 
    return;
}