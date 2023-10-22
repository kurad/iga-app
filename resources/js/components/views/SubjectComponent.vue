<template>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Subjects</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Subjects</li>
            </ol>

            <a href="#" class="btn btn-primary btn-sm mb-3" @click.prevent="newSubject"><i class="fa fa-plus"></i> New
                Subject</a>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    List of Subjects
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th># </th>
                                <th>No </th>
                                <th>Subject Name</th>
                                <th>Level</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in subjects" :key="item.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ item.id }}</td>
                                <td>{{ item.subjName }}</td>
                                <td>{{ item.name }}</td>
                                <td>
                                    <router-link class="btn btn-primary btn-sm"
                                        :to="{ name: 'units', params: { id: item.id } }">View</router-link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- ============================================================================== -->

            <div class="modal" tabindex="-1" id="new_subject_modal">
                <div class="modal-dialog">
                    <form @submit.prevent="storeSubject(form)">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Register a New Subject</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label>Subject Name</label>
                                <input type="text" class="form-control" v-model="form.name">
                            </div>

                            <div class="modal-body">
                                <label>Level</label>
                                <select class="form-control" v-model="form.level_id">
                                    <option v-for="item in levels" :key="item.id" :value="item.id">{{
                                        item.name }}</option>
                                </select>
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

        </div>
    </main>
</template>
<script>
import axios from 'axios';
import $ from 'jquery'
export default {
    data() {
        return {
            subjects: [],
            levels: [],

            form: {
                name: null,
                level_id: null
            },
        }
    },
    methods: {


        async getSubjects() {
            let response = await axios.get('api/v1/subjects');
            this.subjects = response.data;
            console.log(this.subjects);
        },

        newSubject() {
            $('#new_subject_modal').modal('show');
        },
        async storeSubject(form) {
            await axios.post('api/v1/subjects', {
                name: this.form.name,
                level_id: this.form.level_id
            })
                .then((response) => {
                    $('#new_subject_modal').modal('hide');
                    this.subjects.unshift(response.data);
                    // this.isLoading(true)
                    location.reload()
                }).catch((error) => {
                    console.log(error);
                }).finally(() => {
                    $('#new_subject_modal').modal('hide');

                });
        },
    },
    created() {
        this.getSubjects()
    }
}

</script>