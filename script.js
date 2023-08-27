document.addEventListener("DOMContentLoaded", function () {
    const dataForm = document.getElementById("dataForm");

    dataForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const formData = new FormData(dataForm);
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });

        sendDataToServer(data);
    });

    function sendDataToServer(data) {
        // Replace with actual API endpoint or server-side script to handle database insertion
        const apiUrl = "mydb.cp8x2sonvqsb.eu-north-1.rds.amazonaws.com";

        fetch(apiUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(result => {
            console.log("Data sent successfully:", result);
            // You can add further actions here, such as showing a success message to the user
        })
        .catch(error => {
            console.error("Error sending data:", error);
            // Handle error cases here, such as showing an error message to the user
        });
    }
});
