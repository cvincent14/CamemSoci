<template>
    <div class="col">  
        <div class="card">
            <div class="trebuchet card-header">Revenu des imputations des 12 derniers mois de {{ supplierName }}</div>            
            <canvas id="GraphImputation" width="50" height="30" class="p-2"></canvas>   
        </div> 
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
                                borderColor: 'rgb(200, 206, 211)',
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