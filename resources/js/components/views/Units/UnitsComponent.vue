<template>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Units</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Units</li>
            </ol>
            <a href="#" class="btn btn-primary btn-sm mb-3" @click.prevent="newUnit"><i class="fa fa-plus"></i> Add
                Unit</a>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    List of Units for <b>{{ subject.name }} {{ subject.levelName }}</b>
                </div>
                <div class="card-body">

                    <table class="table" v-if="units.length > 0">
                        <thead>
                            <tr>
                                <th># </th>
                                <th>Unit Title</th>
                                <th>Competence</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in units" :key="item.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ item.unit_title }}</td>
                                <td>{{ item.key_unit_competence }}</td>
                                <td>
                                    <router-link class="btn btn-primary btn-sm"
                                        :to="{ name: 'units', params: { id: item.id } }">Lessons</router-link>
                                </td>

                            </tr>
                        </tbody>
                    </table>

                    <table class="table" v-else>

                        <tbody>
                            <tr>
                                <td colspan="3">
                                    <center>Units not Found</center>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- ============================================================================== -->
            <div class="modal" tabindex="-1" id="new_unit_modal">
                <div class="modal-dialog">
                    <form @submit.prevent="storeUnit(form)">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Register a New Unit</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="text" v-model="subject.id" class="form-control">
                                <label>Unit Title</label>
                                <input type="text" class="form-control" v-model="form.unit_title">
                            </div>
                            <div class="modal-body">
                                <label>Key Unit Competence</label>
                                <textarea class="form-control" v-model="form.key_unit_competence"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ===============================================================================-->

            <router-link :to="{ name: 'subjects' }" class="btn btn-primary">Back</router-link>
        </div>
    </main>
</template>
<script>
import axios from 'axios';
import $ from 'jquery'
export default {
    props: ['subject_id'],
    data() {
        return {
            units: [],
            subject: [],

            form: {
                subject_id: null,
                unit_title: null,
                key_unit_competence: null,
            },
        }
    },
    methods: {

        newUnit() {
            $('#new_unit_modal').modal('show');
        },
        async storeUnit(form) {
            await axios.post('http://localhost:8000/api/v1/units', {
                unit_title: this.form.unit_title,
                key_unit_competence: this.form.key_unit_competence,
                subject_id: this.subject.id
            })
                .then((response) => {
                    this.units.unshift(response.data);
                    $('#new_unit_modal').modal('hide');
                    location.reload()
                }).catch((error) => {
                    console.log(error);
                }).finally(() => {
                    $('#new_unit_modal').modal('hide');
                });
        },
        async getUnits() {

            await axios.get(`http://localhost:8000/api/v1/subjects/${this.$route.params.id}`)
                .then((res) => {
                    this.units = res.data
                }).catch(error => {
                    console.log(error)
                    this.units = []
                })
        },

        async getUnitSubject() {

            await axios.get(`http://localhost:8000/api/v1/units/subjects/${this.$route.params.id}`)
                .then((res) => {
                    this.subject = res.data
                }).catch(error => {
                    console.log(error)
                    this.subject = []
                })
        },
    },
    mounted() {
        this.getUnits()
        this.getUnitSubject()
    }
}

</script>