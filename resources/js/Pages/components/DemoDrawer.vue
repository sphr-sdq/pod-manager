<script setup lang="js">
import {
    Drawer,
    DrawerClose,
    DrawerContent,
    DrawerDescription,
    DrawerFooter,
    DrawerHeader,
    DrawerTitle,
    DrawerOverlay,
    DrawerPortal,
    DrawerTrigger

} from '@/components/ui/drawer'
import {PerfectScrollbar} from "vue3-perfect-scrollbar";
</script>

<template>
    <Drawer should-scale-background>
        <DrawerTrigger
            class=" underline underline-offset-4 hover:text-primary "
        >
            قوانین و مقررات
        </DrawerTrigger>
        <DrawerPortal>
            <DrawerOverlay class="fixed bg-black/40 inset-0"/>
            <DrawerContent
                class="bg-gray-100 flex flex-col rounded-t-[10px] h-full mt-24 max-h-[90vh] fixed bottom-0 left-0 right-0"
            >
                <div class="p-4 bg-white rounded-t-[10px] flex-1">
                    <div class="mx-auto w-12 h-1.5 flex-shrink-0 rounded-full bg-gray-300 mb-8"/>
                    <div class="  mx-auto  h-[75vh] ">


                        <PerfectScrollbar>
                            <div class="container">
                                <h2 class="font-medium mb-4">
                                    قوانین استفاده
                                </h2>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab, adipisci alias aliquam
                                    architecto asperiores consectetur, consequatur dolores fuga harum illum mollitia
                                    nemo neque nobis obcaecati odit porro provident quasi qui reprehenderit similique
                                    totam ullam veritatis voluptates! Accusamus aliquid animi at, commodi cumque
                                    dignissimos dolore et eum facere facilis, iusto maiores maxime modi molestiae
                                    mollitia nihil praesentium quaerat quam quasi ratione sapiente veniam, voluptatum.
                                    Accusantium architecto dicta ea error fugiat fugit obcaecati omnis perferendis
                                    tenetur vel. Commodi distinctio doloremque maiores praesentium quae? Adipisci animi
                                    dolor est ex facere iure minima nam quis voluptatibus? Asperiores distinctio ducimus
                                    in inventore quibusdam recusandae tempora voluptas voluptates voluptatum? Dolor non,
                                    nulla? Aliquid dolorem enim fuga modi placeat quae quidem quod vero. Doloremque est,
                                    ex, id illum maiores minima nihil nulla obcaecati pariatur, sint sit vel voluptatem.
                                    Beatae consectetur eaque illum inventore maxime nesciunt quaerat, quis quisquam!
                                    Aspernatur autem dignissimos maiores minima optio provident, quae quasi? At
                                    distinctio dolorem perspiciatis quas velit! Deleniti dolore fuga mollitia saepe?
                                    Aspernatur autem consequatur, debitis incidunt praesentium vel veniam! Aliquid
                                    animi, aperiam at aut commodi, consequuntur, eaque enim exercitationem facere fugiat
                                    fugit id impedit incidunt iste laudantium libero molestiae nemo numquam perferendis
                                    possimus quaerat quam quo saepe sapiente soluta sunt veritatis voluptatem! Alias
                                    corporis culpa debitis, illum reiciendis sequi sunt. A, asperiores error
                                    exercitationem fuga itaque nemo porro qui quidem recusandae reiciendis sequi,
                                    voluptatem. Ab aliquam aliquid animi cupiditate dolorum esse ex iste itaque laborum
                                    molestias nobis officia optio placeat tempore temporibus totam, velit. Ab cum
                                    dignissimos dolore doloremque exercitationem facere inventore ipsam ipsum iste
                                    laborum modi numquam perferendis perspiciatis placeat quam sit, veniam veritatis?
                                    Aliquam aspernatur atque aut consequatur corporis culpa dolore esse ipsam iure
                                    labore maiores, molestiae mollitia nemo, officiis, possimus quasi quisquam
                                    recusandae totam. Ab consectetur consequuntur corporis culpa dolor dolorem ea
                                    expedita, id illo laborum necessitatibus nemo nesciunt nostrum obcaecati, odio
                                    pariatur, quibusdam repudiandae sequi sint suscipit tenetur veritatis voluptatum!
                                    Cupiditate, esse facere minima officiis quas quo quos voluptas. Animi aspernatur
                                    beatae consequatur cupiditate eligendi eum expedita incidunt ipsam minima molestias
                                    nostrum, obcaecati officiis quibusdam recusandae repellendus, saepe sit suscipit
                                    veniam vitae voluptatibus. Adipisci architecto, corporis eum illo libero mollitia,
                                    nulla optio, perferendis ratione repellat tempore ullam! Accusantium aliquid
                                    architecto aspernatur at blanditiis culpa debitis delectus deleniti deserunt
                                    doloremque ea esse est facilis fugit illo illum incidunt ipsum itaque labore magni
                                    maiores molestias necessitatibus nemo nulla odit provident quidem ratione recusandae
                                    reprehenderit sed sint soluta sunt suscipit tempore, vel vero voluptate. Accusamus
                                    amet architecto consectetur debitis dolorum enim ex facere iusto maxime neque
                                    nesciunt numquam odit placeat porro quae quaerat quas quibusdam quisquam repellat
                                    reprehenderit, repudiandae saepe sapiente soluta? Aut beatae dicta est maiores
                                    molestiae obcaecati officia tempora totam unde voluptatum. Ab accusamus accusantium
                                    adipisci aliquid animi aspernatur atque culpa cumque cupiditate delectus dignissimos
                                    dolore dolores dolorum eos, esse est et fuga harum hic ipsum itaque laborum
                                    laudantium minima nam nesciunt nisi nobis nostrum omnis provident quia quisquam quo
                                    repellat repudiandae tempora vel veniam voluptates? A at delectus doloremque esse
                                    expedita explicabo fugit neque obcaecati officia pariatur, porro quos, repellendus
                                    tempora vel voluptatibus. Aliquam aperiam delectus dignissimos eaque illum nostrum
                                    quas voluptas! Aliquid aut beatae consequuntur cum deserunt distinctio ea eos
                                    eveniet explicabo illo illum impedit ipsa iure labore laborum magni maxime, mollitia
                                    neque nostrum pariatur quam quibusdam quo quos reiciendis rerum tempore vero
                                    voluptate! Consectetur eius id ratione sequi tempora! Adipisci aliquam consequatur
                                    dolore est et excepturi facere illum laborum molestias nemo nihil obcaecati quis
                                    recusandae, repellat sint tempora ullam unde vel veniam voluptas! Culpa, eaque
                                    laborum magni recusandae soluta tenetur. Ad aperiam asperiores consequuntur corporis
                                    eligendi eos explicabo id illo nesciunt perspiciatis, possimus quas quasi qui
                                    quisquam, quos, reprehenderit suscipit ullam ut. Ab, accusantium aut, eius facilis
                                    maxime nisi non nulla optio praesentium, provident quasi repellat velit. Ad alias
                                    cum debitis dicta ea esse eum ex expedita hic illo illum inventore ipsam laboriosam
                                    libero modi, nam nesciunt nihil nostrum odio officiis pariatur placeat provident,
                                    quam quidem, quis quos sapiente suscipit tempore temporibus totam vel velit vero
                                    voluptas? Alias, blanditiis consequatur eius magni ratione repellat sit sunt. Ad,
                                    architecto culpa dicta dolorum, excepturi ipsam iure placeat possimus quasi quisquam
                                    repellendus sapiente sequi! Ad amet corporis cum dolores, eaque facilis mollitia
                                    nobis, odit praesentium quam quos repellat similique sunt tempora totam, voluptates
                                    voluptatum. Adipisci aliquid at atque eum mollitia, nesciunt pariatur rerum ullam
                                    vitae voluptas! A aperiam iusto, officia praesentium qui similique sit voluptate!
                                    Amet culpa dignissimos eaque error, iusto optio tenetur voluptas. Alias, cupiditate
                                    ea excepturi in perferendis saepe sed. Dolorum ipsam odit rerum unde veniam? Ab
                                    beatae delectus deleniti dolor excepturi inventore nihil provident quam qui quia
                                    quibusdam totam, ut, voluptatibus. Beatae eius esse impedit libero maxime molestias
                                    quibusdam sunt! A accusantium adipisci alias aut cupiditate deleniti deserunt dicta,
                                    dignissimos dolorem ea enim eos eveniet, illum impedit inventore ipsam itaque
                                    molestiae molestias mollitia nam odit officiis omnis quaerat, quos rerum saepe
                                    sapiente sequi sint sit suscipit tenetur totam ullam vel velit veniam veritatis
                                    vero. Autem error illo maxime officiis omnis! Consectetur ducimus et magnam natus
                                    nihil. Aperiam architecto beatae consectetur culpa, eveniet fuga maiores modi nobis
                                    quas sapiente similique soluta voluptatibus. Accusamus amet consectetur
                                    consequuntur, ducimus esse praesentium qui repellendus sapiente. Aliquid consequatur
                                    dicta odio quos sapiente? Beatae fugiat quaerat rerum. Facere facilis quod vero
                                    voluptatibus? Ab assumenda commodi dicta explicabo fugit, illo odio odit
                                    perspiciatis, possimus praesentium quos sapiente similique temporibus! Ab adipisci
                                    asperiores culpa delectus dicta distinctio dolore dolorem dolores eaque, eius enim
                                    est ipsa ipsam itaque laudantium minus nulla perferendis perspiciatis placeat
                                    possimus quam quibusdam quisquam repudiandae sapiente temporibus totam vero
                                    voluptate. Ab asperiores autem blanditiis, consequuntur culpa delectus, deleniti
                                    dicta dolores ea eligendi error est et expedita hic ipsum magnam nihil nobis nulla
                                    obcaecati quaerat quia quis quo sed sequi voluptatum. Architecto consequuntur enim
                                    eveniet maiores nemo placeat recusandae sint ut vel velit! Culpa dolore ducimus hic
                                    maiores nisi non officia veritatis voluptatibus. Cum cupiditate delectus distinctio
                                    eligendi et eveniet facilis incidunt itaque iure maiores minus molestias, nemo
                                    officiis placeat possimus quae quis quos repellat sapiente tempore vitae voluptates
                                    voluptatibus.
                                </p>
                            </div>
                        </PerfectScrollbar>

                    </div>
                </div>
            </DrawerContent>
        </DrawerPortal>
    </Drawer>
</template>

<style>
.ps {
    height: 100%;
}
</style>
