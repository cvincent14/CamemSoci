<template>
    <div class="col border-left">  
        <h3 class="text-center">Graphe du revenu des imputations sur les 12 derniers mois de la société {{ supplierName }}</h3>            
        <canvas id="GraphImputation" width="30" height="15"></canvas>    
    </div>

</template>

<script>

    export default {
        props: ['supplierName', 'supplierId'],
        data(){
            return{
                infos : [],
                libelle: [],
                totalHt : [],
            }
        },  
        mounted: function () {
            this.$nextTick(function () {
                axios.get('/DiagramImputation/' + this.supplierId)
                .then( response => {
                    this.infos = response.data.totalImputation
                    console.log("Success recup info")             
                })
                .then( () => {
                    
                    Object.entries(this.infos).forEach(([cle, info]) => {
                        this.libelle.push(info.Lib_FR)
                        this.totalHt.push(info.totalHt)
                    })
                    console.log("Success boucle") 
                }) 
                .then( () => { 
                    var ctx = document.getElementById('GraphImputation');
                    var GraphCircDepenseMoisSociete = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels:  this.libelle ,
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
                            },
                        }
                    });
                    this.infos = []
                    this.libelle= []
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