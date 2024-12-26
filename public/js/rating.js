class Rating{
    #upElement = document.getElementById("voteUp")
    #downElement = document.getElementById("voteDown")
    #voteUpCount = document.getElementById("voteUpCount")
    #voteDownCount =document.getElementById("voteDownCount")
    #scoreVal = document.getElementById("scoreVal")

    #image_id = document.getElementById("image_id").value


    constructor() {
        this.#upElement.addEventListener("click", ()=>this.vote(1))
        this.#downElement.addEventListener("click", ()=>{this.vote(-1)})
    }

    async vote(value)
    {
        let response = await this.sendReques({
            voted: value,
            imgID: this.#image_id
        });
        this.updateRating(response)
    }
    async updateRating(rating){
        //voted UP
        if(rating["curUserVote"] > 0){
            this.#upElement.classList.add("btn-success")
            this.#upElement.classList.remove("btn-outline-success")
            this.#downElement.classList.add("btn-outline-danger")
            this.#downElement.classList.remove("btn-danger")
        }
        else if(rating["curUserVote"] < 0){
            this.#upElement.classList.remove("btn-success")
            this.#upElement.classList.add("btn-outline-success")
            this.#downElement.classList.remove("btn-outline-danger")
            this.#downElement.classList.add("btn-danger")
        }
        else if (rating["curUserVote"]===0){
            this.#upElement.classList.replace("btn-success","btn-outline-success")
            this.#downElement.classList.replace("btn-danger","btn-outline-danger")
        }

        this.#scoreVal.textContent = rating["score"]
        colour(this.#scoreVal)

        this.#voteUpCount.textContent=rating["up"]
        this.#voteDownCount.textContent=rating["down"]
    }

    async sendReques(body) {let url = "http://127.0.0.1/?c=submission&a=rate&imgID="+this.#image_id //http://localhost/?c=submission&a=rate
        try {

            let response = await fetch(
                url,
                {
                    method: "POST",
                    body: JSON.stringify(body),
                    headers: {
                        "Content-type": "application/json",
                        "Accept": "application/json",
                    }
                })

            if (response.status !== 200){
                throw new Error("Wrong Response")
            }

            return response.json()
        } catch (ex) {

            return ex;
        }
    }

}