<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dard">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <h5>{{ title }}</h5>
                        </div>
                        <div class="col-md-6">
                            <button  @click="createTask" class="btn btn-success float-end">
                                New Task
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table text-center table-striped px-0">
                                    <thead>
                                        <tr>
                                            <td ><strong>#</strong></td>
                                            <td ><strong>Title</strong></td>
                                            <td ><strong>Date</strong></td>
                                            <td ><strong>Time</strong></td>
                                            <td ><strong>Description</strong></td>
                                            <td ><strong>Action</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(task, index) in Tasks" :key="index"> 
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ task.title }}</td>
                                            <td>{{ task.date }}</td>
                                            <td>{{ task.time }}</td>
                                            <td>{{ task.description }}</td>
                                            <td>
                                                <button @click="editTask(task)" class="btn btn-primary">Edit</button> 
                                                <button @click="deleteTask(task)" class="btn btn-danger ms-2">Remove Task</button> 
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <!-- Modal Start -->
    <div id="taskModal" class="modal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">{{ !editMode ? 'Add New Task' : 'Edit Task'}}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                        <div class="mb-3 form-floating">
                            <input type="text" v-model="TaskData.title" class="form-control " placeholder="Task's Title">
                            <span class="text-danger" v-show="ErrorData.title" >Title is required</span>
                            <label class="floatingInput">Task's Title</label>
                        </div>
                      <div class="form-floating mb-3">
                        <input type="Date" v-model="TaskData.date" class="form-control" id="floatingDate" placeholder="Enter Date">
                        <span class="text-danger" v-show="ErrorData.title" >Date is required</span>
                        <label for="floatingDate">Date</label>
                      </div>
                      <div class="form-floating mb-3">
                        <input type="Time" v-model="TaskData.time" class="form-control" id="floatingInput" placeholder="Enter Time">
                        <span class="text-danger" v-show="ErrorData.date" >Date is required</span>
                        <label for="floatingTime">Time</label>
                      </div>
                      <div class="form-floating">
                        <textarea class="form-control" v-model="TaskData.description" placeholder="Write a Description Here" id="floatingTextarea2" style="height: 100px"></textarea>
                        <span class="text-danger" v-show="ErrorData.description" >Description is required</span>
                        <label for="floatingTextarea2">Description</label>
                      </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" @click="!editMode ? storeTask() : updateTask()"  class="btn btn-primary">{{ !editMode ? 'Save Task' : 'Update Task' }}</button>
            </div>
          </div>
        </div>
      </div>
    <!-- Modal End -->
</template>
<script>
import axios from 'axios';

export default {
    setup: () => ({
        title: 'Tasks',
    }),
    data(){
        return{
            editMode:false,
            TaskData:{
                id:'',
                title:'',
                date:'',
                time:'',
                description:''
            },
            ErrorData:{
                title:false,
                date:false,
                time:false,
                description:false
            },
            Tasks : null
        }
    },
    mounted(){
        this.getTask();
    },
    methods: {
        getTask(){
            axios
                .get('http://127.0.0.1:8000/api/gettasks')
                .then(response => {
                    console.log(response.data);
                    this.Tasks = response.data; 
                })
        },
        createTask(){
            this.editMode = false;
            this.TaskData ={
                id:'',
                title:'',
                date:'',
                time:'',
                description:''
            };
            this.ErrorData ={
                title:false,
                date:false,
                time:false,
                description:false
            }
            $('#taskModal').modal('show');
        },
        editTask(task){
            this.editMode = true;
            this.TaskData ={
                id: task.id,
                title: task.title,
                date:task.date,
                time:task.time,
                description:task.description
            };
            $('#taskModal').modal('show');
        },
        storeTask(){
            this.TaskData.title == '' ? this.ErrorData.title = true : this.ErrorData.title = false, 
            this.TaskData.date == '' ? this.ErrorData.date = true : this.ErrorData.date = false, 
            this.TaskData.time == '' ? this.ErrorData.time = true : this.ErrorData.time = false, 
            this.TaskData.description == '' ? this.ErrorData.description = true : this.ErrorData.description = false 
        
            if(this.TaskData.title && this.TaskData.date && this.TaskData.time && this.TaskData.description ){
                axios
                .post('http://127.0.0.1:8000/api/storetask', this.TaskData)
                .then(response => {
                    console.log(response.data);
                    this.Tasks = response.data;
                })
                .catch(error =>{
                    console.log(error);
                }).finally(() => {
                     $('#taskModal').modal('hide');
                });
            }

        },
        updateTask(){
            this.TaskData.title == '' ? this.ErrorData.title = true : this.ErrorData.title = false, 
            this.TaskData.date == '' ? this.ErrorData.date = true : this.ErrorData.date = false, 
            this.TaskData.time == '' ? this.ErrorData.time = true : this.ErrorData.time = false, 
            this.TaskData.description == '' ? this.ErrorData.description = true : this.ErrorData.description = false 
        
            if(this.TaskData.title && this.TaskData.date && this.TaskData.time && this.TaskData.description ){
                axios
                .put('http://127.0.0.1:8000/api/updatetask/' + this.TaskData.id, this.TaskData)
                .then(response => {
                    console.log(response.data);
                    this.Tasks = response.data;
                })
                .catch(error =>{
                    console.log(error);
                }).finally(() => {
                     $('#taskModal').modal('hide');
                });
            }

        },
        deleteTask(task){
               var isconfirm = confirm('Are you sure, you want to delete?')
               if(isconfirm){
                axios
                .delete('http://127.0.0.1:8000/api/deletetask/' + task.id,)
                .then(response => {
                    console.log(response.data);
                    this.Tasks = response.data;
                })
                .catch(error =>{
                    console.log(error);
                });
               }
              
        }
    },
    
}
</script>
