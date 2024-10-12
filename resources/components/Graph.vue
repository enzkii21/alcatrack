<template>
    <v-container >
        <v-card fluid flat>
            <v-row>
                <v-col align="center" justify="center">
                    <v-img max-height="100" max-width="450" src="images/BAR-CHART.png"/>
                </v-col>
            </v-row>
            <v-row>
                <v-col 
                    cols="12" 
                    sm="8" 
                    md="6" 
                    lg="4" 
                    xl="3"
                >
                    <v-toolbar dense flat>
                        <span class="d-flex justify-center align-center"><b>Batch:</b></span>
                        <v-select
                            v-model="selectedBatch"
                            :items="cOptionBatch"
                            label="Select per Batch"
                            outlined
                            dense
                            hide-details
                        />
                    </v-toolbar>
                </v-col>
            </v-row>
            <v-row>
                <v-col
                    cols="12" 
                    
                >
                    <v-layout align-center justify-center class="layout" >
                        <v-card
                            fluid
                            elevation="20"
                            class="mx-auto pt-3 pb-3 pr-3 pl-3"
                        >
                            <v-card-text>
                                <v-row no-gutters>
                                    <v-col>
                                        <highcharts :options="cGraduateStudents"></highcharts>
                                    </v-col>
                                    
                                </v-row>
                                
                            </v-card-text>
                        </v-card>
                    </v-layout>
                </v-col>
            </v-row>
            
            <!-- <v-row>
                <v-col>
                    <v-layout align-center justify-center class="layout" >
                        <v-card
                            elevation="20"
                            class="mx-auto pt-3 pb-3 pr-3 pl-3"
                        >
                            <v-card-text>
                                <v-row no-gutters>
                                    <v-col>
                                        <highcharts :options="cStatisticsReport"></highcharts>
                                    </v-col>
                                    
                                </v-row>
                                
                            </v-card-text>
                        </v-card>
                    </v-layout>
                </v-col>
            </v-row> -->
        </v-card>
        
    </v-container>
    
</template>

<script>
import { Chart } from 'highcharts-vue'
export default {
    components: {
        highcharts: Chart 
    },
    data(){
        return {
            courseAvailable: [],
            items: [],
            courseID: [],
            countData: [],
            UniqueBatch: [],
            accountData:[],
            selectedBatch: null,
        }
    },

    created() {
        this.mgetCourses()
        this.mgetRegisteredStudents()
        this.mgetAccounts()
    },

    computed: {
        cGraduateStudents(){
            return{
                chart:{
                    type: 'column',
                    height: 500,
                    width: 1000,
                    // plotBackgroundColor: 'teal',
                    
                },
                xAxis:{
                    categories:this.cCourseKindData,
                    labels:{
                        rotation: 300,
                        fontWeight:'bold',
                    },
                    title:{
                        text:'Courses',
                        style:{
                            fontWeight:'bold',
                            color: 'red'
                        }
                    },
                    type:'categories'
                },
                series:[{
                    name: 'Total of Alumnis',
                    type: 'column',
                    data: this.cCountStudent
                },{
                    name: 'Job related to Course',
                    type: 'line',
                    colorByPoint: false,
                    color: '#000000',
                    data: this.cCountJobRelated
                }],
                
                title:{
                    text: this.selectedBatch ? `Graduates Per Course Batch ${this.selectedBatch}`: 'Graduates Per Course',
                    style:{
                        fontWeight:'bold',
                        
                    }
                },
                plotOptions:{
                    series:{
                        colorByPoint: true
                    }
                },
                caption:{
                    text: '*NOTE: Line graph was based on the current JOB of registered accounts',
                    style:{
                        fontStyle: 'italic'
                    }
                },
                yAxis:{
                    title:{
                        text:'Graduate Counts',
                        style:{
                            color: 'red',
                            fontWeight: 'bold'
                        }
                    }
                },
                credits:{
                    enabled: false
                },
                legend:{
                    enabled:false
                },
                tooltip:{

                }
            

                
            }

        },

        cStatisticsReport(){
            return{
                chart:{
                    type: 'Polar ',
                    height: 500,
                    width: 1000,
                    // plotBackgroundColor: 'teal',
                    
                },
                xAxis:{
                    categories:this.cCourseKindData,
                    labels:{
                        rotation: 300,
                        fontWeight:'bold',
                    },
                    title:{
                        text:'Courses',
                        style:{
                            fontWeight:'bold',
                            color: 'red'
                        }
                    },
                    type:'categories'
                },
                series:[{
                    data: this.cCountStudent
                }],
                title:{
                    text: this.selectedBatch ? `Graduates Per Course Batch ${this.selectedBatch}`: 'Graduates Per Course',
                    style:{
                        fontWeight:'bold',
                        
                    }
                },
                plotOptions:{
                    series:{
                        colorByPoint: true
                    }
                },
                yAxis:{
                    title:{
                        text:'Graduate Counts',
                        style:{
                            color: 'red',
                            fontWeight: 'bold'
                        }
                    }
                },
                credits:{
                    enabled: false
                },
                legend:{
                    enabled:false
                },
                tooltip:{

                }
            

                
            }

        },

        cCourseKindData(){
            let temp = []
            this.courseAvailable.filter((res) =>{
                temp.push(res.CourseAbvr)

            })
            return temp
            
        },

        cOptionBatch(){
            return this.UniqueBatch = [...new Set(this.items.map(element => element.Batch))]
        },


        cCountStudent(){

            if(!this.selectedBatch){
                const itemCounts = new Array( this.cCourseKindData.length).fill(0);

                this.cCourseKindData.forEach((courseKind, index) => {
                    itemCounts[index] = this.items.filter(item => item.CourseAbvr=== courseKind).length;
                });
                
                return itemCounts;
            }else{
                const itemCounts = new Array(this.cCourseKindData.length).fill(0);
                let filteredData = this.items.filter(item => item.Batch == this.selectedBatch);

                this.cCourseKindData.forEach((courseKind, index) => {
                    itemCounts[index] = filteredData.filter(item => item.CourseAbvr=== courseKind).length;
                });

                return itemCounts;
            }
        },

        cCountJobRelated(){
            
            if(!this.selectedBatch){

                const itemCounts = new Array( this.cCourseKindData.length).fill(0);

                this.cCourseKindData.forEach((courseKind, index) => {
                    itemCounts[index] = this.accountData.filter(item => item.CourseAbvr=== courseKind).length;
                });
                
                return itemCounts;

            }else{

                const itemCounts = new Array(this.cCourseKindData.length).fill(0);
                let filteredData = this.accountData.filter(item => item.Batch == this.selectedBatch);

                this.cCourseKindData.forEach((courseKind, index) => {
                    itemCounts[index] = filteredData.filter(item => item.CourseAbvr=== courseKind).length;
                });

                return itemCounts;
            }
            
        }


    },

    watch: {
        
    },

    methods: {
        mgetCourses(){
            // this.overlay = true
            axios.get('api/course?method=GET_COURSES').then((res =>{
                this.courseAvailable = res.data
            }))
        },

        mgetRegisteredStudents(){
            axios.get(`api/registeredstudents?method=GET_GRAPH`).then((res)=>{
                this.items = res.data;
            })
        },


        mgetAccounts(){
            axios.get('api/accounts/show?')
            .then((res)=>{
                this.accountData = res.data
            })
        }

        

    },
}
</script>


<style>
.v-layout {
  display: block !important;
}
</style>