class Rating{
    #upElement = document.getElementById("voteUp")
    #downElement = document.getElementById("voteDown")
    #scoreVal = document.getElementById("scoreVal")

    constructor() {
        this.#upElement.addEventListener("click", ()=>this.vote(1))
        this.#downElement.addEventListener("click", ()=>{this.vote(-1)})
    }

    async vote(value)
    {
        let response = await this.sendReques({voted: value});
        this.updateRating(response)
    }
    async updateRating(rating){
        // Nit implemented yet

    }

    async sendReques(body) {let url = "http://127.0.0.1/?c=submission&a=rate" //http://localhost/?c=submission&a=rate
        try {
            // Bild up fetch and wait for response
            let response = await fetch(
                url, // URL to the action
                {
                    method: "POST",
                    body: JSON.stringify(body),
                    headers: { // Set headers for JSON communication
                        "Content-type": "application/json", // Send JSON
                        "Accept": "application/json", // Accept only JSON as response
                    }
                });
            // If return code do not match our expected value throw error
            if (response.status !== 200) throw new Error("Wrong Response");

            return response.json()
        } catch (ex) {
            // On any error just return error
            return ex;
        }
    }

}