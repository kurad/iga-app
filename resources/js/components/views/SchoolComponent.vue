<template>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>

            <a href="#" class="btn btn-primary btn-sm mb-3" @click.prevent="newSchool"><i class="fa fa-plus"></i> New
                School</a>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    List of Schools
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th># </th>
                                <th>School Name</th>
                                <th>School Type</th>
                                <th>Province</th>
                                <th>District</th>
                                <th>Sector</th>
                                <th>Status</th>
                                <th>Action</th>

                            </tr>
                        </thead>

                        <tbody>

                            <tr v-for="(item, index) in schools" :key="item.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.type }}</td>
                                <td>{{ item.province_name }}</td>
                                <td>{{ item.district_name }}</td>
                                <td>{{ item.sector_name }}</td>
                                <td v-if="item.school_status == 1">True</td>
                                <td v-else>False</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" type="button">View</button>
                                </td>

                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- ============================================================================== -->

            <div class="modal" tabindex="-1" id="new_school_modal">
                <div class="modal-dialog">
                    <form @submit.prevent="storeSchool(form)">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Register a New School</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label>School Name</label>
                                <input type="text" class="form-control" v-model="form.school_name">
                            </div>

                            <div class="modal-body">
                                <label>School Type</label>
                                <select class="form-control" v-model="form.school_type">
                                    <option>--- Select ---</option>
                                    <option> Public School </option>
                                    <option> Private School </option>
                                    <option> Government Aid School </option>
                                </select>
                            </div>
                            <div class="modal-body">
                                <label>Province</label>
                                <select class="form-control" v-model="province" @change="getDistrict()">
                                    <option v-for="item in provinces" :key="item.id" :value="item.id">{{
                                        item.province_name }}</option>
                                </select>
                            </div>
                            <div class="modal-body">
                                <label>District</label>
                                <select class="form-control" v-model="district" @change="getSector()">
                                    <option v-for="item in districts" :key="item.id" :value="item.id">{{
                                        item.district_name }}</option>
                                </select>
                            </div>

                            <div class="modal-body">
                                <label>Sector</label>
                                <select class="form-control" v-model="form.school_location">
                                    <option v-for="item in sectors" :key="item.id" :value="item.id">{{
                                        item.sector_name }}</option>
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
import { ref } from 'vue';
export default {
    data() {
        return {
            schools: [],
            province: 0,
            provinces: [],
            districts: [],
            district: 0,
            sectors: [],
            sector: 0,
            form: {
                school_name: null,
                school_type: null,
                school_location: null
            },
            // isLoading: ref(false)
        }
    },
    methods: {
        async getSchools() {
            let response = await axios.get('api/v1/school-info');
            this.schools = response.data;
            console.log(this.schools);
        },
        newSchool() {
            $('#new_school_modal').modal('show');
        },
        async storeSchool(form) {
            await axios.post('api/v1/school', {
                name: this.form.school_name,
                type: this.form.school_type,
                sector_id: this.form.school_location
            })
                .then((response) => {
                    this.schools.unshift(response.data);
                    $('#new_school_modal').modal('hide');
                    // this.isLoading(true)
                    location.reload()
                }).catch((error) => {
                    console.log(error);
                }).finally(() => {
                    $('#new_school_modal').modal('hide');

                });
        },
        getProvinces() {
            axios.get('api/v1/province')
                .then(function (response) {
                    this.provinces = response.data;
                }.bind(this));
        },

        getDistrict() {
            axios.get('api/v1/district', {
                params: {
                    province_id: this.province
                }
            }).then(function (response) {
                this.districts = response.data
            }.bind(this));
        },
        getSector() {
            axios.get('api/v1/sector', {
                params: {
                    district_id: this.district
                }
            }).then(function (response) {
                this.sectors = response.data
            }.bind(this));
        },
    },
    created() {
        this.getSchools()
        this.getProvinces()
    }
}

</script>