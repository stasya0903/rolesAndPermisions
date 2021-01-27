<template>
    <div class="row justify-content-center">

            <div class="card p-4">
                <div class="row g-3">
                    <div class="dropdown col-6">
                        <label>Регион <span class="required">*</span></label>
                        <vue-simple-suggest

                            type="select"
                            v-model="inputRegion"
                            display-attribute="title"
                            value-attribute="id"
                            :list="regions"
                            :filter-by-query="true"
                            placeholder="Выберите регион"
                            @input="choseRegion()"
                        >
                            <div slot="misc-item-below" slot-scope="{ suggestions }" v-if="loadingRegions"
                                 class="misc-item">
                                <span>Загрузка...</span>
                            </div>
                        </vue-simple-suggest>
                    </div>
                    <div class="dropdown col-6">
                        <label>Район</label>
                        <vue-simple-suggest
                            v-model="inputDistrict"
                            display-attribute="formalname"
                            value-attribute="aoid"
                            :list="districts"
                            :filter-by-query="true"
                            placeholder="Выберите регион"
                            @input="choseDistrict"
                        >
                            <div slot="misc-item-below" slot-scope="{ suggestions }" v-if="loadingDistricts"
                                 class="misc-item">
                                <span>Загрузка...</span>
                            </div>
                        </vue-simple-suggest>
                    </div>
                </div>
                <div class="row">
                    <div class="dropdown col-6">
                        <label>Населенный пункт</label>
                        <vue-simple-suggest
                            v-model="inputCity"
                            display-attribute="'shortname.formalname"
                            value-attribute="aoguid"
                            :list="citiesAndTowns"
                            :filter-by-query="true"
                            placeholder="Выберите населенный пункт"
                        >
                            <div slot="misc-item-below" slot-scope="{ suggestions }" v-if="loadingCity"
                                 class="misc-item">
                                <span>Загрузка...</span>
                            </div>
                        </vue-simple-suggest>
                    </div>
                    <div class="dropdown col-6">
                        <label>Улица</label>
                        <vue-simple-suggest
                            v-model="inputCity"
                            display-attribute="formalname"
                            value-attribute="aoguid"
                            :list="citiesAndTowns"
                            :filter-by-query="true"
                            placeholder="Выберите населенный пункт"
                        ></vue-simple-suggest>
                    </div>
                </div>
                <div class="row">
                    <div class="dropdown col-3">
                        <label>Дом/Участок</label>
                        <vue-simple-suggest
                            v-model="inputCity"
                            display-attribute="formalname"
                            value-attribute="aoid"
                            :list="citiesAndTowns"
                            :filter-by-query="true"
                            placeholder="Выберите населенный пункт"
                        ></vue-simple-suggest>
                    </div>
                    <div class="dropdown col-3">
                        <label>Квартира</label>
                        <vue-simple-suggest
                            v-model="inputCity"
                            display-attribute="formalname"
                            value-attribute="aoid"
                            :list="citiesAndTowns"
                            :filter-by-query="true"
                            placeholder="Выберите населенный пункт"
                        ></vue-simple-suggest>
                    </div>
                    <div class="dropdown col-6">
                        <label>Индекс</label>
                        <vue-simple-suggest
                            v-model="inputCity"
                            display-attribute="formalname"
                            value-attribute="aoid"
                            :list="citiesAndTowns"
                            :filter-by-query="true"
                            placeholder="Выберите населенный пункт"
                        ></vue-simple-suggest>
                    </div>
                </div>
            </div>
            <div class="card">
            </div>
        </div>

</template>

<script>
    import axios from 'axios'
    import 'vue-simple-suggest/dist/styles.css'

    export default {
        data() {
            return {
                regions: [],
                districts: [],
                citiesAndTowns: [],
                streets: [],
                houses: [],
                chosenRegion: {},
                chosenDistrict: {},
                chosenCityOrTown: {},
                chosenStreet: {},
                chosenHouse: {},
                inputRegion: '',
                inputDistrict: '',
                inputCity: '',
                loadingRegions: false,
                loadingDistricts: false,
                loadingCity: false,


            }
        },
        methods: {
            getRegions() {
                this.loadingRegions = true;
                axios.get(`/api/getRegions`)
                    .then((response) => {
                        this.regions = response.data;
                        this.loadingRegions = false;
                    });
            },
            choseRegion() {
                let region = this.regions.find(r => {
                    return r.title.toLowerCase() === this.inputRegion.toLowerCase()
                });

                if (region) {
                    this.chosenRegion = region;
                    this.getDistricts();
                    this.getCities();
                }

            },
            getDistricts() {
                this.loadingDistricts = true;
                axios.get(`/api/getDistricts/${this.chosenRegion.fias_code}`)
                    .then((response) => {
                        this.districts = response.data;
                        this.loadingDistricts = false;
                    });
            },

            choseDistrict() {
                let district = this.districts.find(d => {
                    return d.formalname.toLowerCase() === this.inputDistrict.toLowerCase()
                });
                if (district) {
                    this.chosenDistrict = district;
                    this.citiesAndTowns = this.citiesAndTowns.filter(c => c.regioncode = this.chosenDistrict.regioncode)
                }

            },
            getCities() {
                this.loadingCity = true;
                axios.get(`/api/getCities/${this.chosenRegion.fias_code}`)
                    .then((response) => {
                        this.citiesAndTowns = response.data;
                        this.loadingCity = false;
                    });
            },
            choseCity() {

                let city = this.citiesAndTowns.find(d => {
                    return d.formalname.toLowerCase() === this.inputCity.toLowerCase()
                });
                if (city) {
                    this.chosenCityOrTown = city;
                    this.citiesAndTowns = this.citiesAndTowns.filter(c => c.regioncode = this.chosenDistrict.regioncode)
                    this.getStreets();
                }

            },

            getStreets() {
                axios.get(`/api/getStreets/${this.this.chosenCityOrTown.aoguid}`)
                    .then((response) => {
                        this.citiesAndTowns = response.data;
                    });
            },

            resetSelection() {
                this.selectedItem = {};
                this.selectedItem_Level2 = {};
                this.selectedItem_Level3 = {};
                this.$nextTick(() => this.$refs.dropdowninput.focus())
                this.$emit('on-item-reset')
            },
            selectItem(chosenOption) {
                this.selectedItem = chosenOption;
                this.inputValue = '';
                this.secondLevel = this.itemsArray.filter(i => {
                    return (i.title === chosenOption.title && i.code.match(/^([0-9]*[.][0-9])$/))
                });
                this.thirdLevel = [];
                this.$emit('on-item-selected', this.selectedItem.id)
            },

            selectItemLevel2(e) {
                let id = e.target.value;
                if (parseInt(id) === 0) {
                    this.thirdLevel = [];
                    this.updateSelectedValue(this.selectedItem.id)
                } else {
                    let theItem = this.itemsArray.find(i => i.id === parseInt(id));
                    this.selectedItem_level2 = theItem;
                    this.thirdLevel = this.itemsArray.filter(i => {
                        return (
                            i.title === theItem.title &&
                            i.title_level2 === theItem.title_level2 &&
                            i.code.match(/^([0-9]*[.][0-9][.][0-9])$/))
                    });
                    this.updateSelectedValue(this.selectedItem_level2.id)
                }
            },
            selectItemLevel3(e) {
                let id = e.target.value;
                if (parseInt(id) > 0) {
                    let chosenId = this.itemsArray.find(i => i.id === parseInt(id)).id;
                    this.updateSelectedValue(chosenId);
                } else {
                    this.updateSelectedValue(this.selectedItem_level2.id);
                }


            },
            updateSelectedValue(id) {
                this.$emit('on-item-selected', id)
            },

            itemVisible(item) {
                let currentName = item.title.toLowerCase()
                let currentInput = this.inputRegion.toLowerCase()
                return currentName.includes(currentInput)
            },
            districtVisible(item) {
                let currentName = item.formalname.toLowerCase()
                let currentInput = this.inputDistrict.toLowerCase()
                return currentName.includes(currentInput)
            },

        },
        mounted() {
            this.getRegions();
        }
    }
</script>

<style>
    .dropdown {
        position: relative;
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
    }

    .dropdown-input, .dropdown-selected {
        width: 100%;
        padding: 10px 16px;
        border: 1px solid transparent;
        background: #edf2f7;
        line-height: 1.5em;
        outline: none;
        border-radius: 8px;
    }

    .dropdown-input:focus, .dropdown-selected:hover {
        background: #fff;
        border-color: #e2e8f0;
    }

    .dropdown-input::placeholder {
        opacity: 0.7;
    }

    .dropdown-selected {
        font-weight: bold;
        cursor: pointer;
    }

    .dropdown-list {
        position: absolute;
        width: 100%;
        max-height: 500px;
        margin-top: 4px;
        overflow-y: auto;
        background: #ffffff;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        border-radius: 8px;
        z-index: 10;
    }

    .dropdown-item {
        display: flex;
        width: 100%;
        padding: 11px 16px;
        cursor: pointer;
    }

    .dropdown-item:hover {
        background: #edf2f7;
    }

</style>
