<template>
    <app-layout title="Tareas">

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar Usuario
            </h2>
        </template>


        <div class="py-12">

            <!-- <pre>
                {{$page}}
            </pre> -->

            {{errors}}

            <pre>
                {{customers}}
            </pre>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <form @submit.prevent="submit" class="px-8 pt-6 pb-8 mb-4">
                        <div class="mt-4">
                            <jet-label for="Nombre" value="Nombre" />

                            <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus />

                            <div v-if="errors.name">{{ errors.name }}</div>
                        </div>

                        <div class="mt-4">
                            <jet-label for="email" value="Email" />

                            <jet-input id="email" type="text" class="mt-1 block w-full" v-model="form.email" required autofocus />

                            <Jet-Errors :message="errors.email" />
                        </div>

                        <div class="mt-4">

                            <jet-label for="password" value="Password" />

                            <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autofocus />

                            <div v-if="errors.password" class="flex items-center bg-red-500 text-white text-sm font-bold px-4 py-3" role="alert">
                            <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                            <p>{{ errors.password }}</p>
                            </div>

                        </div>

                        <div class="mt-4">
                            <jet-label for="avantar" value="Avantar" />

                            <jet-input id="avantar" type="file" class="mt-1 block w-full" @input="form.avatar = $event.target.files[0]" required autofocus v-if="!customers.profile_photo_path" />

                            <Jet-Errors :message="errors.avantar" />
                        </div>

                        <jet-button class="ml-4 " >
                            Enviar
                        </jet-button>



                        <div v-if="success" class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
                            <p class="font-bold">{{success}}</p>
                            <p class="text-sm">Gracias por guardar</p>
                        </div>

                        <div v-if="customers.profile_photo_path" >
                            <img class="h-20 w-70 rounded border object-cover m-auto block" :src="customers.profile_photo_url" :alt="customers.name" />
                        </div>

                         <Link v-if="customers.profile_photo_path" class="ml-4 btn btn-danger text-center block text-sm bold cursor-pointer" @click="deleteAvatar">
                            Limpiar 3
                        </Link>



                    </form>

                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'

import JetErrors from '@/Jetstream/InputError.vue'


import JetInput from '@/Jetstream/Input.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetButton from '@/Jetstream/Button.vue'

import AppLayout from '@/Layouts/AppLayout.vue'
import Welcome from '@/Jetstream/Welcome.vue'

import { Link } from '@inertiajs/inertia-vue3'

// PETICIONES AXIOS
import { Inertia } from '@inertiajs/inertia'

 export default defineComponent({
        components: {
            AppLayout,
             Welcome,
             JetErrors,
             JetInput,
             JetLabel,
             JetButton,
             Link,
        },
        props:{
            errors: Object,
            success: String,
            customers: Object,
        },
        data(){
            return {
               form:{
                    name: this.customers.name,
                    email: this.customers.email,
                    password:"",
                    avatar:""
               }
            }
        },
        methods:{
           submit(){
               console.log("Llegaste")

            //    Inertia.post(route('userList.store',{
            //        name:this.name,
            //        email:this.email,
            //        password:this.password,
            //    }))

            //    Inertia.put(route('userList.update',{'customers': this.customers}),this.form)

            // Para ubir archivos no puede ser enviado con put debe ser enmascarado
            Inertia.post(route('userList.update',{'customers': this.customers}),
                {
                    _method: 'put',
                    name: this.form.name,
                    email: this.form.email,
                    password: this.form.password,
                    avatar: this.form.avatar
                }
            );


           },
           deleteAvatar: function (){
            //    console.log("hola");
                    Inertia.delete(route('userList.delete',{'customers': this.customers}));


           }
        }
    })
</script>

