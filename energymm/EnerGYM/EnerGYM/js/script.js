  $(document).ready(function(){
    $("a").on("click", function(event) {
      if (this.hash !== "") {
        event.preventDefault();
        var hash = this.hash;
        $('html, body').animate({
          scrollTop: $(hash).offset().top
        }, 800, function(){
          window.location.hash = hash;
        });
      } 
    });
  });
  const scheduleData = {
    monday: [
      { class: "Yoga", time: "8:00am - 10:00am", coach: "John Doe" },
      { class: "Cardio", time: "10:00am - 10:30am", coach: "James Holmes" }
    ],
    tuesday: [
    ]
  };

  function showSchedule(day) {
    const scheduleBody = document.getElementById("schedule-body");
    scheduleBody.innerHTML = ""; 

    const schedule = scheduleData[day];
    if (schedule) {
      schedule.forEach(item => {
        const row = document.createElement("tr");
        row.innerHTML = `
          <th scope="row">${item.class}</th>
          <td>${item.time}</td>
          <td>${item.coach}</td>
          <td class="text-success">Join now</td>
        `;
        scheduleBody.appendChild(row);
      });
    } else {
      scheduleBody.innerHTML = "<tr><td colspan='4'>No schedule available for this day</td></tr>";
    }
  }

  showSchedule('monday');
  
function toggleButton(button, day) {
  var buttons = document.querySelectorAll('.days-navigation button');
  buttons.forEach(function(btn) {
    btn.classList.remove('clicked');
  });
  button.classList.add('clicked');
  showSchedule(day);

}

