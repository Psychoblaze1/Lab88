<template>
  <AsidePartial>
    <template #content>
      <div class="flex flex-col h-full justify-between">
        <ul>
          <NavItem toName="sample-stepper" title="New Sample">
            <template #icon>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-6 h-6"
              >
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
              </svg>
            </template>
          </NavItem>
          <!--  -->
          <NavItem toName="scanner" title="Scan QR/Barcode">
            <template #icon>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-6 h-6"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"
                />
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z"
                />
              </svg>
            </template>
          </NavItem>
        </ul>
      </div>
    </template>
  </AsidePartial>
  <CardPartial class="p-4 col-span-1 w-full overflow-y-auto">
    <template #title>Samples </template>
    <template #content>
      <div
        v-show="loading"
        class="flex flex-row w-full min-h-60 text-center justify-center text-2xl p-10"
      >
        Fetching Updated Sample Data
      </div>

      <table class="w-full h-full text-xs">
        <thead class="bg-gray-200 text-black sticky top-0">
          <tr class="text-left"></tr>
          <!-- Filters -->
          <tr class="text-left bg-gray-100 p-2">
            <th class="p-2">
              <div class="flex flex-row -p2">
                <button>A/D</button>
                <input
                  v-model="filter.searchField"
                  type="text"
                  placeholder="Search"
                  class="w-full"
                />
              </div>
            </th>
            <th class="p-2">
              <select v-model="filter.asset" class="w-full">
                <option value="">All Assets</option>
                <option v-for="(asset, key) in uniqueAssets">
                  <span class="capitalize"> {{ asset }} </span>
                </option>
              </select>
            </th>
            <th class="p-2">
              <select v-model="filter.type" class="w-full">
                <option value="">All Types</option>
                <option v-for="(type, key) in types">
                  <span class="capitalize"> {{ type }} </span>
                </option>
              </select>
            </th>
            <th class="p-2">
              <select v-model="filter.status" class="w-full">
                <option value="">All Statuses</option>
                <option v-for="(status, key) in statuses" :value="key">
                  <span class="uppercase"> {{ status }}</span>
                </option>
              </select>
            </th>
            <th class="p-2">
              <!-- DROPDOWN -->
              <div class="flex justify-start bg-gray-200">
                <div>
                  <div class="dropdown relative">
                    <button
                      @click="columnOptionsToggle = !columnOptionsToggle"
                      class="text-xs capitalize flex items-center"
                      type="button"
                    >
                      Data
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-4 h-4"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                        />
                      </svg>
                    </button>
                    <ul
                      v-show="columnOptionsToggle"
                      class="absolute w-64 right-0 bg-gray-100 text-xs z-50 float-left py-2 list-none text-left rounded-lg shadow-lg mt-1 m-0 bg-clip-padding border-none"
                    >
                      <li class="flex flex-row w-full p-2 hover:bg-gray-200">
                        <input type="checkbox" />
                        Received Date
                      </li>
                      <li class="flex flex-row w-full p-2 hover:bg-gray-200">
                        <input type="checkbox" />
                        Tested Date
                      </li>
                      <li class="flex flex-row w-full p-2 hover:bg-gray-200">
                        <input type="checkbox" />
                        Released Date
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <!--  -->
            </th>
          </tr>
        </thead>
        <tbody class="overflow-y-auto">
          <tr
            v-for="(sample, key) in samples"
            :key="key"
            class="border-b border-opacity-20 hover:bg-gray-200"
          >
            <td class="p-2">
              <router-link
                :to="'/sample/' + sample.id"
                class="text-blue-500 hover:underline"
              >
                {{ sample.name }}
              </router-link>
            </td>

            <td class="p-2">
              {{ sample.sample_point_id }}
            </td>
            <td class="p-2">
              {{ sample.type }}
            </td>

            <td class="p-2">
              {{ statuses[sample.status] }}
            </td>
            <td class="p-2">
              <button @click="deleteSample(sample.id, key)">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="w-4 h-4"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                  />
                </svg>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </template>
  </CardPartial>
</template>
<script>
import AsidePartial from "../../partials/AsidePartial.vue";
import NavItem from "../../components/navigation/NavItem.vue";

import CardPartial from "../../partials/CardPartial.vue";
import Paginate from "../../components/navigation/Paginate.vue";

export default {
  name: "SampleDash",
  setup() {
    const headers = [
      { label: "Sample Id" },
      { label: "Type" },
      { label: "Asset Chain" },
      { label: "Status" },
      { label: "Actions" },
    ];
  },
  components: { NavItem, AsidePartial, CardPartial, Paginate },
  data() {
    return {
      loading: false,
      columnOptionsToggle: false,
      filter: {
        searchField: "",
        asset: "",
        type: "",
        status: "",
      },
    };
  },
  created() {
    if (!this.$store.getters["sample/samples"].length) {
      this.loading = true;
      this.getSamples();
    }
  },
  methods: {
    async deleteSample(sample_id, key) {
      if (confirm("Confirm sample deletion")) {
        this.loading = true;
        await this.$store
          .dispatch("sample/deleteSample", {
            sample_id: sample_id,
            arr_key: key,
          })
          .then((r) => {
            this.loading = false;
          });
      }
    },
    async getSamples() {
      await this.$store.dispatch("sample/getSamples").then((r) => {
        this.loading = false;
      });
    },
  },
  computed: {
    samples() {
      return this.$store.getters["sample/samples"].filter((sample) => {
        let state = true;
        //Searchfield
        if (this.filter.searchField.length >= 3) {
          if (
            !sample.name.toLowerCase().includes(this.filter.searchField.toLowerCase())
          ) {
            state = false;
          }
        }
        //Asset
        if (this.filter.asset !== "") {
          if (sample.sample_point_id !== this.filter.asset) {
            state = false;
          }
        }
        //Type
        if (this.filter.type !== "") {
          if (sample.type !== this.filter.type) {
            state = false;
          }
        }
        //Status
        if (this.filter.status !== "") {
          if (sample.status !== this.filter.status) {
            state = false;
          }
        }
        //
        if (state) {
          return sample;
        }
      });
    },
    types() {
      return this.$store.getters["sample/sampleTypes"];
    },
    statuses() {
      return this.$store.getters["sample/statuses"];
    },
    uniqueAssets() {
      return [
        ...new Set(
          this.$store.getters["sample/samples"].map((sample) => sample.sample_point_id)
        ),
      ];
    },
  },
};
</script>

<style scoped></style>
