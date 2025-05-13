<template>
   <!-- Hero Start -->
   <section class="relative mt-20">
      <div class="container-fluid md:mx-4 mx-2">
         <div class="relative pt-40 pb-52 table w-full rounded-2xl shadow-md overflow-hidden duration-1000" id="home"
            :style="{ 'background-image': `url(${randomImage})`, backgroundPosition: 'center' }">
            <div class="absolute inset-0 bg-black/60"></div>
            <div class="container relative">
               <div class="grid grid-cols-1">
                  <div class="md:text-start text-center">
                     <h1 class="font-bold text-white lg:leading-normal leading-normal text-4xl lg:text-5xl mb-6">We will
                        help you find <br> your <span class="text-yellow-600">Wonderful</span> home</h1>
                     <p class="text-white/70 text-xl max-w-xl">A great plateform to buy, sell and rent your properties
                        without any agent or commisions.</p>
                  </div>
               </div><!--end grid-->
            </div><!--end container-->
         </div>
      </div><!--end Container-->
   </section><!--end section-->
   <!-- Hero End -->
   <section class="relative md:pb-24 pb-16">
      <HomeSearch :categories="categories"/>
      <!-- <div class="container relative lg:mt-24 mt-16">
         <transparency :transparency="true"/>
      </div> -->
      <div class="container relative lg:mt-24 mt-16">
         <FeaturedProperties
         :featured_properties="featured_properties"
         :featured="true"
         :featureds="true"
         :featuredgrid="'grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 mt-8 gap-[30px]'"
         :grids="''" />
      </div>

      <div class="container relative lg:mt-24 mt-16">
         <work />
      </div>

      <div class="container relative lg:mt-24 mt-16">
      <ProjectsProperties
        :projects_properties="projects_properties"
        :featured="true"
        :featureds="true"
        :featuredgrid="'grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 mt-8 gap-[30px]'"
        :grids="''"
      />
      </div>

      <!-- <div class="container relative lg:mt-24 mt-16">
         <client />
      </div>
      <getintouch /> -->
   </section>
   <!-- <footers />
   <switcher /> -->
</template>
<script>
import image from '@frontend-assets/images/bg/01.jpg';
import image2 from '@frontend-assets/images/bg/02.jpg';
import image3 from '@frontend-assets/images/bg/03.jpg';
import HomeSearch from '@/frontend/components/buy-sell-rent/home-search.vue';
import FeaturedProperties from '@/frontend/components/featured-properties/featured-properties.vue';
import ProjectsProperties from '@/frontend/components/projects/projects-properties.vue';
// import transparency from '@/frontend/components/transparency-control.vue';
import work from '@/frontend/components/how-it-work.vue';
// import client from '@/frontend/components/clients/client.vue';
// import getintouch from '@/frontend/components/get-in-touch.vue';

export default {
   data() {
      return {
         randomImage: '',
         backgroundImages: [
            image,
            image2,
            image3
         ]
      }
   },
   props :{
    featured_properties:Object,
    projects_properties:Object,
    categories:Object,
   },
   components: {

    HomeSearch,
    FeaturedProperties,
    work,
    ProjectsProperties
    //   transparency,
    //   client,
    //   getintouch,

   },
   mounted() {
      this.changeBackground();
      setInterval(this.changeBackground, 4000);

   },
   methods: {
      changeBackground() {
         const randomIndex = Math.floor(Math.random() * this.backgroundImages.length);
         this.randomImage = this.backgroundImages[randomIndex];
      },
   }
}
</script>

<style lang="scss" scoped></style>
