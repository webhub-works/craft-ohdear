<template>
  <div>

    <h2>{{ $t('Check details') }}</h2>

    <div v-if="loadingSite" class="oh-w-full oh-justify-center oh-items-center oh-flex" style="height: 74px;">
      <loader/>
    </div>

    <table v-if="!loadingSite" class="data collapsible">
      <tbody>
      <tr>
        <th class="light">{{ $t('Status') }}</th>
        <td>
          <check-badge loader-position="right" :check="check"/>
        </td>
      </tr>
      <tr>
        <th class="light">{{ $t('Last run') }}</th>
        <td>{{ lastRun }}</td>
      </tr>
      </tbody>
    </table>

    <h2>{{ $t('Scores') }}</h2>



    <h2>{{ $t('Metrics') }}</h2>

  </div>
</template>

<script>
import Api from "../../helpers/Api";
import {fetchesSite, hasCheck} from "../../helpers/Mixins";

export default {
  name: "Lighthouse",
  mixins: [fetchesSite, hasCheck],
  data() {
    return {
      checkType: 'lighthouse',
      latestLighthouseReport: null,
    }
  },
  mounted() {
    this.fetchLatestLighthouseReport();
  },
  methods: {
    fetchLatestLighthouseReport() {
      return Api.getLatestLighthouseReport().then(response => {
        this.latestLighthouseReport = response.data.latestLighthouseReport;
      })}
    }
}
</script>
