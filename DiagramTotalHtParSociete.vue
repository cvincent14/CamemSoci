<template>
    <div class="col">   
        <div class="card">  

            <div class="trebuchet card-header" style="font-family:">Dépenses des 12 derniers mois de {{ supplierName }}</div>   
            <canvas id="GraphCircDepenseMoisSociete" width="50" height="30" class="p-2"></canvas>  
        </div>
    </div>

</template>

<script>

    export default {
        props: ['supplierName', 'supplierId'],
        data(){
            return{
                infos : [],
                date: [],
                totalHt : [],
                infos2 : [],
                totalHtAfter : [],
            }
        },  
        mounted: function () {
            this.$nextTick(function () {
                axios.get('/DiagramTotalHtParSociete/' + this.supplierId)
                .then( response => {
                    this.infos = response.data.detailMonthSociety
                    this.infos2 = response.data.detailLastYearSociety
                    console.log("Success recup info")             
                })
                .then( () => {
                    
                    Object.entries(this.infos).forEach(([cle, info]) => {
                        this.date.push(info.date.substr(5))
                        this.totalHt.push(info.totalHt)
                    })
                    
                    Object.entries(this.infos2).forEach(([cle, info]) => {
                        this.totalHtAfter.push(info.totalHt)
                    })
                    console.log("Success boucle") 
                }) 
                .then( () => {

                    var IndexJanvier = this.date.indexOf("01");
                    this.date.splice(IndexJanvier, 1, 'Janvier');

                    var IndexFevrier = this.date.indexOf("02");
                    this.date.splice(IndexFevrier, 1, 'Février');

                    var IndexMars = this.date.indexOf("03");
                    this.date.splice(IndexMars, 1, 'Mars');

                    var IndexAvril = this.date.indexOf("04");
                    this.date.splice(IndexAvril, 1, 'Avril');

                    var IndexMai = this.date.indexOf("05");
                    this.date.splice(IndexMai, 1, 'Mai');

                    var IndexJuin = this.date.indexOf("06");
                    this.date.splice(IndexJuin, 1, 'Juin');

                    var IndexJuillet = this.date.indexOf("07");
                    this.date.splice(IndexJuillet, 1, 'Juillet');

                    var IndexAout = this.date.indexOf("08");
                    this.date.splice(IndexAout, 1, 'Août');

                    var IndexSeptembre = this.date.indexOf("09");
                    this.date.splice(IndexSeptembre, 1, 'Septembre');

                    var IndexOctobre = this.date.indexOf("10");
                    this.date.splice(IndexOctobre, 1, 'Octobre');

                    var IndexNovembre = this.date.indexOf("11");
                    this.date.splice(IndexNovembre, 1, 'Novembre');

                    var IndexDecembre = this.date.indexOf("12");
                    this.date.splice(IndexDecembre, 1, 'Décembre');

                    console.log('Conversion réussi');

                })
                .then( () => { 
                    var ctx = document.getElementById('GraphCircDepenseMoisSociete');
                    var GraphCircDepenseMoisSociete = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels:  this.date ,
                            datasets: [{
                                label : "L'année dernière",
                                borderWidth : 0.5,
                                backgroundColor: 'rgb(32, 168, 216)',
                                borderColor: 'rgb(200, 206, 211)',
                                data: this.totalHtAfter,
                            },
                            {
                                label : "L'année actuelle",
                                borderWidth : 0.5,
                                backgroundColor: 'rgb(99, 194, 222)',
                                borderColor: 'rgb(200, 206, 211)',
                                data: this.totalHt,
                            }]
                        },
                        options:
                        {
                            legend:
                            {
                                display: true
                            },
                            
                        }
                    });
                    this.date= []
                    this.totalHt = []
                    this.totalHtAfter = []
                    console.log("Success Graph")
                })    
                .catch(error => {
                    console.log('ERROR!')
                }) 
            })
        },
        
    }
 
</script>