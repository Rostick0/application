(function () {
    const projectName = document.querySelector('#project_name');
    const projectInn = document.querySelector('#project_inn');

    if (!projectName || !projectInn) return;

    const url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/party";
    const token = "e46a32a8c6e9fb20b9342e0047f1374cb2c4afce";

    const options = {
        method: "POST",
        mode: "cors",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "Authorization": "Token " + token
        },
        body: JSON.stringify({
            query: projectInn.value
        })
    }

    projectInn.oninput = throttle(() => {
        fetch(url, options)
            .then(response => response.json())
            .then(result => {
                if (result.suggestions.length <= 0) return;

                if (result?.suggestions[0]?.value === undefined) return;

                projectName.value = result?.suggestions[0]?.value;
            })
            .catch(error => console.log("error", error));
    }, 1000);
})()