<template>
    <div class="container-fluid mt--6 bg-gradient-info">
        <div class="row justify-content-center">
            <div class="col-md-12">


                <div class="card">
                    
                    <div class="row">
                        <div class="col-lg-8 col-md-14 bg-gradient-default">

                            <div class="card card-tasks bg-gradient-default">
                                <div class="card-header bg-gradient-default"><center>
                                    <h4 class="title d-inline text-info" @click="abrirModal"> Tienes alguna pregunta ? </h4>
                                    <h2 class="card-category d-inline text-danger" @click="abrirModal">Resuelvela aqui</h2></center>
                                    
                                </div>
                                <div class="card-body bg-gradient-default">
                                    <div class="table-full-width table-responsive">

                                        <div class="tab-pane active" id="publicaciones">
                                            <!--
                                            <button type="button" class="btn btn-outline-info" @click="abrirModal">Nueva Publicacion </button>     
                                            -->    
                                            <div class="full-background" v-for="v_miimagen in adminis">
                                                <div class="full-background">
                                                    <div class="btn-group" style="float: right;">
                                                        <button type="button" class="btn btn-outline-info btn-simple animation-on-hover" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                        ...
                                                        </button>
                                                        <div class="dropdown-menu">
                                                        <a class="dropdown-item btn btn-outline-info" @click="abrirModificacion(v_miimagen)">Editar</a>
                                                        <a class="dropdown-item btn btn-outline-info" @click="eliminarPublicacion(v_miimagen.id)">Eliminar</a>
                                                        </div>
                                                    </div>
                                                    <div class="card card-blog card-plain bg-gradient-default">
                                                        
                                                        <div class="position-relative">

                                                            
                                                            <div v-for="todo in users">
                                                                
                                                                <ul v-if="(todo.id) === (v_miimagen.user_id)">
                                                                    <img alt="" :src="'/storage/'+todo.image" class="avatar avatar-sm rounded-circle">
                                                                    <a class="text-danger">
                                                                        {{todo.name}} !!
                                                                    </a>
                                                                </ul>
                                                                <p v-else></p>
                                                            </div>
                                                        <center>
                                                            <a class="full-background">
                                                            <img alt="" :src="'/storage/'+v_miimagen.image" width='500' height='250' class="page-header min-vh-75 m-3 border-radius-xl">
                                                            </a>
                                                        </center>
                                                        </div>
                                                        <div class="card-body px-0 pt-4">
                                                        <p class="text-info">
                                                            {{v_miimagen.title}}
                                                        </p>
                                                        <p class="text-info">
                                                            {{v_miimagen.body}}
                                                        </p>
                                                        <input type="text" class="form-control form-control-muted" @click="abrirModal1" placeholder="Comentar">
                                                        <br>
                                                        <center>
                                                            <button type="button" class="btn bg-gradient-info">Ver comentarios</button>
                                                            <button class="btn btn bg-gradient-info btn-fab btn-icon btn-round">
                                                                <i class="fas fa-heart"></i>
                                                            </button>

                                                        </center>
                                                        
                                                        </div>
                                                    </div>
                                                </div>             
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>



                        <div class="col-lg-4 col-md-12 bg-gradient-default">
                            <div class="card bg-gradient-default">
                                <div class="card-header bg-gradient-default">
                                    <h4 class="card-title text-info"><center>Web Log Programming</center></h4>

                                    <h4 class="card-title text-info"><center>Hecho por programadores</center></h4>

                                    <h4 class="card-title text-info"><center>Para programadores</center></h4>
                                </div>
                                <div class="card-body bg-gradient-default">
                                    <center>
                                        <a class="full-background">
                                            <img alt="" :src="image" width='270' height='550'>
                                        </a>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <!---  Publicacion  
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="publicaciones">
                                
                                <button type="button" class="btn btn-outline-info" @click="abrirModal">Nueva Publicacion </button>          
                                
                                <div class="full-background" v-for="v_miimagen in adminis">
                                    <div class="full-background">
                                        <div class="btn-group" style="float: right;">
                                            <button type="button" class="btn btn-outline-info btn-simple animation-on-hover" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="sr-only">Toggle Dropdown</span>
                                            ...
                                            </button>
                                            <div class="dropdown-menu">
                                            <a class="dropdown-item btn btn-outline-info" @click="abrirModificacion(v_miimagen)">Editar</a>
                                            <a class="dropdown-item btn btn-outline-info" @click="eliminarPublicacion(v_miimagen.id)">Eliminar</a>
                                            </div>
                                        </div>
                                        <div class="card card-blog card-plain">
                                            
                                            <h1 class="text-gradient text-info text-gradient font-weight-bold text-sm text-uppercase"> {{v_miimagen.user_id}} !!</h1>
                                            
                                            
                                            <div class="position-relative">
                                            <center>
                                                <a class="full-background">
                                                <img alt="" :src="'/storage/'+v_miimagen.image" width='500' height='250' class="page-header min-vh-75 m-3 border-radius-xl">
                                                </a>
                                            </center>
                                            </div>
                                            <div class="card-body px-0 pt-4">
                                            <p>
                                                {{v_miimagen.body}}
                                            </p>
                                            <input type="text" class="form-control form-control-muted" placeholder="Comentar">
                                            <br>
                                            <center>
                                                <button type="button" class="btn bg-gradient-info">Ver comentarios</button>
                                                <button class="btn btn bg-gradient-info btn-fab btn-icon btn-round">
                                                    <i class="fas fa-heart"></i>
                                                </button>

                                            </center>
                                            
                                            </div>
                                        </div>
                                    </div>             
                                </div>
                            </div>
                        </div>
                    </div>

                    --->

                    



                     <!---  Modal de Publicacion  --->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-default modal-dialog-centered modal-" role="document">
                    <div class="modal-content bg-gradient-info">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Nueva publicacion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="cierraModal">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control" id="exampleFormControlInput1" v-model="admin.title" placeholder="Titulo">
                        <br>
                        <input type="text" class="form-control" id="exampleFormControlInput1" v-model="admin.body" placeholder="¿Que sucede?">
                        <br>
                        <!--<input type="text" class="form-control" id="exampleFormControlInput1" v-model="admin.image" placeholder="Imagen">
                        <br> -->
                        <input type="file" class="form-control" id="exampleFormControl" accept="image/*" @change="subirFoto">
                        
                        <br>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-info" data-dismiss="modal" @click="cierraModal">Close</button>
                        <button type="button" class="btn btn-outline-info" @click="guardarPublicacion">Guardar</button>
                    </div>
                    </div>
                </div>
            </div>



            <!---  Modal de Comentario  --->
            <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-default modal-dialog-centered modal-" role="document">
                    <div class="modal-content bg-gradient-info">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Nuevo Comentario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="cierraModal1">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control" id="exampleFormControlInput1" v-model="comen.comment" placeholder="Nombre del comentario">
                        <br>
                        <input type="number" class="form-control" id="exampleFormControlInput2" v-model="comen.post_id" placeholder="publicacion">
                        <br>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-info" data-dismiss="modal" @click="cierraModal1">Close</button>
                        <button type="button" class="btn btn-outline-info" @click="guardarComentario">Guardar</button>
                    </div>
                    </div>
                </div>
            </div>










                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import image from "./img/fondo1.gif";
    
    export default {
        mounted() {
            console.log('Iniciar')
            this.publicacion();
            this.userV();
            this.comentarioPro();
        }, data(){
            return{
                adminis: {},
                admin: {},
                users: {},
                usa: {},
                com: {},
                comen: {},
                editando: false,
                image: image,
            }
        }, methods:{
            subirFoto(e){
                this.admin.foto = e.target.files[0];
            },
            userV(){
                axios.get('/usa').then((response) => {
                    this.users = response.data;
                }).catch((error) => {
                    console.log(error.response);
                })
            },
            publicacion(){
                axios.get('/selectImage').then((response) => {
                    this.adminis = response.data;
                }).catch((error) => {
                    console.log(error.response);
                })
            }, eliminarPublicacion(param_admin){
            axios.delete('/deleteImage/'+param_admin).then((response)=>{
              alert("Eliminación corrrecta");
              this.publicacion();
            }).catch((error)=>{
              console.log(error.response);
            })
          }, abrirModal(){
            $("#exampleModal").modal('toggle');
          }, guardarPublicacion(){
            const datosAdministrador = new FormData();
            datosAdministrador.set('title', this.admin.title)
            datosAdministrador.set('body', this.admin.body)
            datosAdministrador.set('image', this.admin.foto);
            if(this.editando){
              datosAdministrador.set('id', this.admin.id);
              axios.post("/updateImage", datosAdministrador).then((response)=>{
              this.publicacion();
              alert("Actualizado correctamente");
              this.cierraModal();
              }).catch((error)=>{
                console.log(error.response);
              })
            }else{
              axios.post("/insertImage", datosAdministrador).then((response)=>{
              this.publicacion();
              alert("Registro exitoso")
              this.cierraModal();
              }).catch((error)=>{
                console.log(error.response);
              })
            }
          }, abrirModificacion(param_admin){
            this.editando = true;
            this.admin = param_admin;
            $("#exampleModal").modal('toggle');
          }, cierraModal(){
            $("#exampleModal").modal('toggle');
            this.admin = {};
            this.editando = false;
          },
          comentarioPro(){
                axios.get('/selectComent').then((response) => {
                    this.com = response.data;
                }).catch((error) => {
                    console.log(error.response);
                })
            }, guardarComentario(){
            const datosAdministrador = new FormData();
            datosAdministrador.set('comment', this.comen.comment)
            datosAdministrador.set('post_id', this.comen.post_id);
            if(this.editando){
              datosAdministrador.set('id', this.comen.id);
              axios.post("/updateComent", datosAdministrador).then((response)=>{
              this.comentarioPro();
              alert("Actualizado correctamente");
              this.cierraModal1();
              }).catch((error)=>{
                console.log(error.response);
              })
            }else{
              axios.post("/insertComent", datosAdministrador).then((response)=>{
              this.comentarioPro();
              alert("Registro exitoso")
              this.cierraModal1();
              }).catch((error)=>{
                console.log(error.response);
              })
            }
          }, abrirModal1(){
            $("#exampleModal1").modal('toggle');
          }, abrirModificacion1(param_admin){
            this.editando = true;
            this.comen = param_admin;
            $("#exampleModal1").modal('toggle');
          }, cierraModal1(){
            $("#exampleModal1").modal('toggle');
            this.comen = {};
            this.editando = false;
          }
        }
    }
</script>