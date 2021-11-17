<template>
    <app-layout title="Tareas">

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Usuarios
            </h2>
        </template>

        <!-- <pre>
            {{users}}
        </pre> -->

        <pre>
            {{$page}}
        </pre>



        <div class="py-12">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="container m-3">
                    <Link class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded cursor" :href="route('userList.create')" >
                                Crear Usuarios
                    </Link>

                </div>

                    <pre>
                      <!--  Nos trae todo los datos del usuario autenticado{ {$page}} -->
                    </pre>

                   <!-- This example requires Tailwind CSS v2.0+ -->
                        <div class="flex flex-col m-5">
                            <div class="-my-2 overflow-x-auto">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">

                                    <!-- Buscador -->
                                    <form method="get" class="flex mb-4 w-40" @submit.prevent="submit" >
                                        <jet-input v-model="form.search"  id="buscador" type="text" class="mt-1 block " placeholder="Buscar por correo o nombre" />
                                        <button type="submit" class="btn btn-primary">Buscar</button>
                                    </form>
                                    <!-- END Buscador -->

                                    <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nombre y Apellidos
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Descripción
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tiempo invertido
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Unidad
                                        </th>

                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only" >Edit</span>
                                        </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">

                                        <tr v-for="user in users.data" :keu="user.id">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60" alt="">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{user.name}}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{user.email}}
                                                    </div>
                                                </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">Descripcion</div>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Active
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                Admin
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">


                                                <Link class="btn btn-primary mr-2"
                                                :href="route('userList.edit',{customers:user})"   >
                                                        Editar
                                                </Link>

                                                <Link class="btn btn-info mr-2"
                                                :href="route('userList.show',{customers:user})"   >
                                                        Ver
                                                </Link>
                                                <!-- <Link class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded cursor"
                                                :href="route('userList.destroy',{customers:user})"  method="DELETE" >
                                                        Eliminar
                                                </Link> -->
                                                <button @click="modalOpen=true; selectUser=user"  class="btn btn-danger" >Eliminar


                                                </button>

                                            </td>
                                        </tr>


                                        <!-- More people... -->
                                    </tbody>
                                    </table>

                                    <Paginator :paginator="users"  class="mt-10"/>
                                </div>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>


        <jet-DialogModal :show="modalOpen" >
            <template v-slot:title>
                <h2>Eliminar Usuarios </h2>
            </template>

             <template v-slot:content>
                <p v-if="selectUser" >¿Seguro que quieres eliminar el usuario: {{selectUser.email}}  ?</p>
            </template>

             <template v-slot:footer>
                  <jet-button class="float-left ml-4 bg-green-500 hover:bg-green-800"  @click="deleteUser">
                    Aceptar
                </jet-button>

                <jet-button class="ml-4 bg-red-500 hover:bg-red-800"  @click="modalOpen=false">
                    Cerrar
                </jet-button>
            </template>
        </jet-DialogModal>

    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import Welcome from '@/Jetstream/Welcome.vue'

import JetDialogModal from '@/Jetstream/DialogModal.vue';
import JetButton from '@/Jetstream/Button.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetInput from '@/Jetstream/Input.vue'

import { Link } from '@inertiajs/inertia-vue3'

// Importando componente externo de paginador
import Paginator from '@/Components/Paginator.vue';

// PETICIONES AXIOS
import { Inertia } from '@inertiajs/inertia'

 export default defineComponent({
        components: {
            AppLayout,
             Welcome,
             Link,
             JetDialogModal,
             JetButton,
             Paginator,
             JetInput,
             JetLabel
        },
        props:{'users':{
                    type: Array,
                    requited:true
                },
                'search':{
                    typr:String
                }


            },
        data(){
            return{
                modalOpen:false,
                selectUser:Object,
                form:{
                    search: this.search,
                },
            }
        },
        methods:{
            submit: function () {
                console.log(this.form.search)
                Inertia.get(route('userList.index', this.form))
            },
            deleteUser: function (){
                console.log(this.selectUser)
                // alert("Elimnado")


                // if(!confirm(`¿Seguro que quieres eliminar el usuario: ${data.email} ?`)) return ;
                Inertia.delete(route('userList.destroy',{'customers':this.selectUser}))
                this.modalOpen=false;

            }
        }
    })


    /**
     *  Iconografia recomendada
     *  https://heroicons.dev/
     *
     */

    /**
     *   PARA CONGIGUARA FLASH
     *   https://inertiajs.com/shared-data
     *
     *   en el archivo handlertiaRequest
     *
     */
</script>
