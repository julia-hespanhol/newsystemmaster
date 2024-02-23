const app = Vue.createApp({
    //Aqui ficam as funções, templates, dados
    data(){
        return{
            showBooks: true,
            title: "The final Empire",
            author: "Júlia Hespanhol",
            age: "42"

        }
    },
    methods: {
        toogleShowBooks() {
            this.showBooks = false
        }
    }
    
})

app.mount('#app')