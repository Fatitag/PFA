
function loadSchedule(day) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            document.getElementById("schedule-body").innerHTML = this.responseText;
        }
    };
    xhr.open("GET", "php/fetch_schedule.php?day=" + day, true);
    xhr.send();
}
