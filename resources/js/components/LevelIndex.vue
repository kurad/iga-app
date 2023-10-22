<template>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>

            <a href="#" class="btn btn-primary btn-sm mb-3" @click.prevent="newLevel"><i class="fa fa-plus"></i> New</a>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    DataTable Example
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Name</th>

                            </tr>
                        </thead>

                        <tbody>

                            <tr v-for="item in levels" :key="item.id">
                                <td>{{ item.name }}</td>

                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- ============================================================================== -->

            <div class="modal" tabindex="-1" id="newLevel">
                <div class="modal-dialog">
                    <form @submit.prevent="storeLevel(form)">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">New Level</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label>Level Name</label>

                                <input type="text" class="form-control" v-model="form.level_name">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
            levels: [],
            form: {
                level_name: null
            }
        }
    },
    methods: {
        async getLevels() {
            let response = await axios.get('api/v1/levels');
            this.levels = response.data;
            console.log(this.levels);
        },
        newLevel() {
            $('#newLevel').modal('show');
        },
        async storeLevel(form) {
            await axios.post('api/v1/levels', {
                name: this.form.level_name
            })
                .then((response) => {
                    this.levels.unshift(response.data);
                    $('#newLevel').modal('hide');
                }).catch((error) => {
                    console.log(error);
                }).finally(() => {
                    $('#newLevel').modal('hide');

                });
        }
    },
    created() {
        this.getLevels()
    }
}

</script>