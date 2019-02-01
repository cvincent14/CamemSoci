<template>
    <div>
        <h2>Graphe sur les dépenses des 12 derniers mois de la société {{ uneSociete[0].societe }}</h2>               
            <div class="m-5">
                <canvas id="GraphCircDepenseMoisSociete" width="40" height="15"></canvas>
            </div>      
    </div>

</template>

<script>

    export default {
        props: ['uneSociete'],
        data(){
            return{
                infos : [],
                date: [],
                totalHt : [],   
            }
        },  
        mounted: function () {
            this.$nextTick(function () {
                axios.get('/' + this.uneSociete[0].IDfournisseur)
                .then( response => {
                    this.infos = response.data.detailMonthSociety
                    console.log("Success recup info")             
                })
                .then( () => {
                    
                    Object.entries(this.infos).forEach(([cle, info]) => {
                        this.date.push(info.date)
                        this.totalHt.push(info.totalHt)
                    })
                    console.log("Success boucle") 
                }) 
                .then( () => { 
                    var ctx = document.getElementById('GraphCircDepenseMoisSociete');
                    var GraphCircDepenseMoisSociete = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels:  this.date ,
                            datasets: [{
                                borderWidth : 0.5,
                                backgroundColor: tableColor,
                                borderColor: 'rgb(0, 0, 0)',
                                data: this.totalHt,
                            }]
                        },
                        options:
                        {
                            legend:
                            {
                                display: false
                            }
                        }
                    });
                    this.infos = []
                    this.date= []
                    this.totalHt = []
                    console.log("Success Graph")
                })    
                .catch(error => {
                    console.log('ERROR!')
                }) 
            })
        },
        
    }
 
</script>