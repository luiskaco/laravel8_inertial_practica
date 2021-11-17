<template>
    <app-layout title="Tareas">

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mostrar USuario
            </h2>
        </template>

        <div class="py-12">

            <pre>
                {{$page}}
            </pre>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">


                        <div class="mt-4">
                            <jet-label for="Nombre" :value="`Nombre ${customers.name}`" />

                        </div>

                        <div class="mt-4">
                            <jet-label for="email" :value="`Email ${customers.email}`" />
                        </div>




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

// PETICIONES AXIOS
import { Inertia } from '@inertiajs/inertia'

 export default defineComponent({
        components: {
            AppLayout,
             Welcome,
             JetErrors,
             JetInput,
             JetLabel,
             JetButton
        },
        props:{
            customers:Object,
            errors: Object,
            success: String
        },
        data(){
            return {
               form:{
                    name:"Margaret FLorencia",
                    email:"mflorencia@gmail.com",
                    password:"123456"
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
               Inertia.post(route('userList.store'),this.form)
           }
        }
    })
</script>
