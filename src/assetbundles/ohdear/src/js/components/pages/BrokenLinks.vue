<template>
    <div>

        <h2>{{ $t('Check details') }}</h2>

        <div v-if="loadingSite" class="oh-w-full oh-justify-center oh-items-center oh-flex" style="height: 74px;">
            <loader/>
        </div>

        <table class="data" v-if="!loadingSite">
            <tbody>
            <tr>
                <th class="light">{{ $t('Status') }}</th>
                <td>
                    <check-badge :check="check"/>
                </td>
            </tr>
            <tr>
                <th class="light">{{ $t('Last run') }}</th>
                <td class="xs:oh-whitespace-nowrap">{{ lastRun }}</td>
            </tr>
            </tbody>
        </table>

        <h2>{{ $t('Broken Links') }}</h2>

        <div v-if="loadingBrokenLinks" class="oh-w-full oh-justify-center oh-items-center oh-flex" style="height: 74px;">
            <loader/>
        </div>

        <div class="oh-w-full oh-flex oh-justify-center oh-flex-wrap oh-py-8" v-if="!brokenLinks.length && !loadingBrokenLinks">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="oh-w-32 oh-h-32">
                <path class="oh-fill-current oh-text-gray-300" d="M19.48 13.03l-.02-.03a1 1 0 1 1 1.75-.98A6 6 0 0 1 16 21h-4a6 6 0 1 1 0-12h1a1 1 0 0 1 0 2h-1a4 4 0 1 0 0 8h4a4 4 0 0 0 3.48-5.97z"/>
                <path class="oh-fill-current oh-text-gray-500" d="M4.52 10.97l.02.03a1 1 0 1 1-1.75.98A6 6 0 0 1 8 3h4a6 6 0 1 1 0 12h-1a1 1 0 0 1 0-2h1a4 4 0 1 0 0-8H8a4 4 0 0 0-3.48 5.97z"/>
            </svg>
            <p class="oh-w-full oh-text-center">{{ $t('Nice work, all of your links are safe and sound.') }}</p>
        </div>

        <table class="data fullwidth" v-if="brokenLinks.length && !loadingBrokenLinks">
            <thead>
            <tr>
                <th>{{ $t('Element') }}</th>
                <th>{{ $t('Broken Link') }}</th>
                <th>{{ $t('HTTP Status') }}</th>
                <th scope="col" data-attribute="link" data-icon="world" title="Link"/>
            </tr>
            </thead>
            <tbody>
            <tr v-for="brokenLink in brokenLinks">
                <td>

                    <div class="chip-content" v-if="brokenLink.element" :title="brokenLink.element.title">
                        <span class="status" :class="brokenLink.element.status"></span>
                        <craft-element-label class="label">
                            <a class="label-link" :href="brokenLink.element.cpEditUrl"><span>{{brokenLink.element.title}}</span></a>
                        </craft-element-label>
                        <div class="chip-actions"></div>
                    </div>

                    <div class="chip-content" v-if="!brokenLink.element">
                        <span class="status disabled"></span>
                        <craft-element-label class="label">
                            <span>{{ $t('Element not found') }}</span>
                        </craft-element-label>
                        <div class="chip-actions"></div>
                    </div>

                </td>
                <td>
                    <a :href="brokenLink.crawledUrl" :title="brokenLink.crawledUrl" target="_blank">{{ brokenLink.shortCrawledUrl }}</a>
                </td>
                <td>
                    <badge v-if="brokenLink.isPotentiallyFixedSince(check.latestRunEndedAt)"
                           color="teal"
                           label="Pending"
                           :dotless="true">
                        <info-icon class="oh-ml-1 oh-mt-0.5">{{ $t('This broken link may have been fixed because the element has been updated since the last check.') }}<br>{{ $t('Wait until the next check or request a new run.') }}</info-icon>
                    </badge>
                    <http-status-badge v-else :status="brokenLink.statusCode"/>
                </td>
                <td data-title="Link" data-attr="link">
                    <a :href="brokenLink.foundOnUrl" :title="$t('Visit webpage where the broken link was found')" rel="noopener" target="_blank" data-icon="world"/>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
</template>

<script>
    import Api from "../../helpers/Api";
    import {fetchesSite, hasCheck} from "../../helpers/Mixins";
    import BrokenLink from "../../resources/BrokenLink";

    export default {
        name: "BrokenLinks",
        mixins: [fetchesSite, hasCheck],
        data() {
            return {
                checkType: 'broken_links',
                loadingBrokenLinks: true,
                brokenLinks: [],
            }
        },
        mounted() {
            this.fetchBrokenLinks();
        },
        computed: {
            internalBrokenLinks() {
                return this.brokenLinks.filter(link => {
                    try {
                        return new URL(link.crawledUrl).hostname === new URL(link.foundOnUrl).hostname;
                    } catch (e) {
                        return true;
                    }
                })
            },
            externalBrokenLinks() {
                return this.brokenLinks.filter(link => {
                    try {
                        return new URL(link.crawledUrl).hostname !== new URL(link.foundOnUrl).hostname;
                    } catch (e) {
                        return false;
                    }
                })
            }
        },
        methods: {
            fetchBrokenLinks() {
                return Api.getBrokenLinks()
                    .then(response => {
                        this.loadingBrokenLinks = false;
                        this.brokenLinks = response.data.brokenLinks.map(brokenLink => BrokenLink.fromJson(brokenLink));
                    })
            }
        }
    }
</script>
