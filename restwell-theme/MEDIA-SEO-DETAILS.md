# Media SEO Details

Scope: files currently in `assets/images/media/`, intended to be uploaded into the WordPress Media Library.

Use this as the fill-in sheet when adding media to WordPress or documenting static theme media. For images, fill in **Title**, **Alt Text**, **Caption** where useful, and **Description** in the Media Library. For videos, use **Title**, **Caption**, **Description**, and make sure decorative background videos stay `aria-hidden="true"` in templates.

## Homepage Hero Admin Fields

The homepage hero is now Media Library-driven. After upload, fill these page fields in WP Admin:

- `hero_media_id`: `restwell-whitstable-tankerton-beach-flyover-hero.mp4`
- `hero_mobile_video_id`: `restwell-whitstable-tankerton-beach-flyover-mobile.mp4`
- `hero_video_poster_id`: `restwell-whitstable-rainbow-coast.webp`

Once those fields point to uploaded Media Library attachments, the theme does not need the matching files in `assets/images/media/`.

## Rules To Follow

- Keep alt text between roughly 10 and 125 characters.
- Describe the image content, not the filename.
- Include "Restwell", "Whitstable", "accessible holiday", or "Tankerton" only where it reads naturally.
- Do not add alt text to purely decorative images if nearby text already explains the section.
- Do not lazy-load hero/LCP images.
- Add `loading="lazy"` and `decoding="async"` for below-fold images.
- Use `width` and `height` or WordPress responsive image output to prevent CLS.
- Keep the large originals as source-only unless WordPress is generating responsive sizes from them.

## Homepage Hero Video

### `restwell-whitstable-tankerton-beach-flyover.mp4`

- Type: Source/master video
- Size: `8738KB`
- Dimensions: `3840x720`
- Title: `Tankerton beach flyover source video`
- Alt Text: Not applicable for video
- Caption: `Source video of the Tankerton and Whitstable coastline.`
- Description: `Original high-resolution flyover footage used to generate compressed homepage hero video files. Keep as source-only; do not serve directly to normal visitors.`
- Usage: Source-only
- SEO/Performance Notes: Too large for public hero playback. Use `restwell-whitstable-tankerton-beach-flyover-hero.mp4` and `restwell-whitstable-tankerton-beach-flyover-mobile.mp4` instead.

### `restwell-whitstable-tankerton-beach-flyover-hero.mp4`

- Type: Homepage hero video
- Size: `1882KB`
- Dimensions: `1280x720`
- Title: `Tankerton beach flyover hero video`
- Alt Text: Not applicable for video
- Caption: `Tankerton beach and Whitstable coastline seen from above.`
- Description: `Compressed desktop hero video for the Restwell homepage, generated from the high-resolution Tankerton beach flyover source.`
- Usage: Homepage desktop hero video
- SEO/Performance Notes: Decorative background media. Keep `muted`, `autoplay`, `loop`, `playsinline`, `preload="metadata"`, and `aria-hidden="true"`.

### `restwell-whitstable-tankerton-beach-flyover-mobile.mp4`

- Type: Homepage hero video
- Size: `1127KB`
- Dimensions: `960x540`
- Title: `Tankerton beach flyover mobile video`
- Alt Text: Not applicable for video
- Caption: `Mobile-optimised Tankerton beach flyover for the Restwell homepage.`
- Description: `Compressed mobile hero video for the Restwell homepage, generated from the high-resolution Tankerton beach flyover source.`
- Usage: Homepage mobile hero video
- SEO/Performance Notes: Use as the mobile `<source>` for the homepage video. Keep `preload="metadata"`.

### `restwell-whitstable-rainbow-coast.webp`

- Type: Hero poster image
- Size: `41KB`
- Dimensions: `1920x829`
- Title: `Rainbow over Whitstable coastline`
- Alt Text: `Rainbow over the Whitstable coastline near Tankerton`
- Caption: `A rainbow over the Whitstable and Tankerton coastline.`
- Description: `Wide coastal image used as a lightweight poster fallback for the Restwell homepage hero video.`
- Usage: Homepage hero video poster, coastal hero image
- SEO/Performance Notes: Strong LCP candidate. Do not lazy-load if used as the main hero image/poster.

## Accessibility And Property Images

### `accessible-bathroom.webp`

- Type: Content image
- Size: `46KB`
- Dimensions: `1080x1350`
- Title: `Accessible wet room bathroom`
- Alt Text: `Accessible wet room with adjustable sink, shower chair, and level floor`
- Caption: `The adapted wet room includes an adjustable sink and shower support.`
- Description: `Portrait image showing the Restwell accessible bathroom with level floor access, adjustable basin, mirror, shower controls, and shower chair.`
- Usage: Accessibility page, property page, gallery
- SEO/Performance Notes: Good size. Use `loading="lazy"` below the fold.

### `adjustable-sink.webp`

- Type: Source image
- Size: `370KB`
- Dimensions: `2400x3200`
- Title: `Adjustable bathroom sink source image`
- Alt Text: `Accessible bathroom sink with adjustable height support`
- Caption: `Source image of the adjustable bathroom sink.`
- Description: `High-resolution source image showing the adapted bathroom sink and support controls at Restwell.`
- Usage: Source-only unless WordPress generates responsive sizes
- SEO/Performance Notes: Do not serve directly in templates. Use `adjustable-sink-display.webp` for static display.

### `adjustable-sink-display.webp`

- Type: Content image
- Size: `48KB`
- Dimensions: `1080x1440`
- Title: `Adjustable accessible bathroom sink`
- Alt Text: `Accessible bathroom sink with adjustable height support`
- Caption: `The wet room includes an adjustable sink for easier supported use.`
- Description: `Optimised display image of the Restwell wet room sink and accessibility support features.`
- Usage: Accessibility details, property gallery, care equipment sections
- SEO/Performance Notes: Use this instead of the source file when referencing static theme media directly.

### `profiling-bed.webp`

- Type: Content image
- Size: `71KB`
- Dimensions: `1080x1350`
- Title: `Profiling bed in accessible bedroom`
- Alt Text: `Profiling bed in a bright accessible bedroom at Restwell Whitstable`
- Caption: `The accessible bedroom includes a profiling bed and ceiling track hoist.`
- Description: `Portrait image of the Restwell accessible bedroom showing the profiling bed, ceiling track, and natural light.`
- Usage: Property page, accessibility page, bedroom equipment content
- SEO/Performance Notes: Good size. Use lazy loading below the fold.

### `bedroom.webp`

- Type: Content image
- Size: `67KB`
- Dimensions: `1080x1350`
- Title: `Restwell bedroom`
- Alt Text: `Comfortable bedroom at Restwell with natural light and teal blind`
- Caption: `A calm bedroom prepared for an accessible holiday stay.`
- Description: `Portrait image of a Restwell bedroom with a double bed, bedside lamp, teal blind, and warm neutral decor.`
- Usage: Property page, gallery, stay overview
- SEO/Performance Notes: Good size. Use lazy loading below the fold.

### `kitchen-portrait-view.webp`

- Type: Source image
- Size: `211KB`
- Dimensions: `2400x3200`
- Title: `Accessible kitchen source image`
- Alt Text: `Kitchen at Restwell with white cupboards, oven, and worktop space`
- Caption: `Source image of the Restwell kitchen.`
- Description: `High-resolution portrait source image of the Restwell kitchen.`
- Usage: Source-only unless WordPress generates responsive sizes
- SEO/Performance Notes: Prefer `kitchen-portrait-view-display.webp` or `kitchen-portrait-view-webp.webp`.

### `kitchen-portrait-view-webp.webp`

- Type: Optimised source image
- Size: `95KB`
- Dimensions: `2400x3200`
- Title: `Restwell kitchen portrait`
- Alt Text: `Kitchen at Restwell with white cupboards, oven, and worktop space`
- Caption: `The kitchen is set up for practical self-catering during a stay.`
- Description: `Optimised full-resolution WebP image of the Restwell kitchen, with white cupboards, oven, fridge freezer, and worktop space.`
- Usage: Prefer over `kitchen-portrait-view.webp` if full resolution is needed
- SEO/Performance Notes: Good compression for the dimensions, but still use responsive sizes in templates.

### `kitchen-portrait-view-display.webp`

- Type: Content image
- Size: `40KB`
- Dimensions: `1080x1440`
- Title: `Restwell kitchen display image`
- Alt Text: `Kitchen at Restwell with white cupboards, oven, and worktop space`
- Caption: `The kitchen supports practical self-catering during an accessible stay.`
- Description: `Optimised display image of the Restwell kitchen for property and guest information pages.`
- Usage: Property gallery, practical details, self-catering content
- SEO/Performance Notes: Best static version for direct template use.

## Door, Entrance, And Garden Access Images

### `entrance.webp`

- Type: Content image
- Size: `104KB`
- Dimensions: `1080x1350`
- Title: `Restwell entrance hallway`
- Alt Text: `Entrance hallway at Restwell with level access toward patio doors`
- Caption: `A clear entrance route helps guests move through the property more easily.`
- Description: `Portrait image showing the Restwell entrance hallway with a view toward glazed patio doors and natural light.`
- Usage: Accessibility page, arrival information, property page
- SEO/Performance Notes: Slightly above the ideal content target. Acceptable if served responsively.

### `int-front-door.webp`

- Type: Source image
- Size: `351KB`
- Dimensions: `2400x3200`
- Title: `Internal front door source image`
- Alt Text: `Internal front door route at Restwell with clear hallway access`
- Caption: `Source image of the internal front door route.`
- Description: `High-resolution source image showing the internal front door and hallway route at Restwell.`
- Usage: Source-only
- SEO/Performance Notes: Do not serve directly. Use `int-front-door-display.webp`.

### `int-front-door-display.webp`

- Type: Content image
- Size: `68KB`
- Dimensions: `1080x1440`
- Title: `Internal front door route`
- Alt Text: `Internal front door route at Restwell with clear hallway access`
- Caption: `The hallway gives a clear route from the entrance into the home.`
- Description: `Optimised display image of the internal front door and hallway route at Restwell.`
- Usage: Arrival/access information, property details
- SEO/Performance Notes: Good display size.

### `conservatory-doors.webp`

- Type: Source image
- Size: `274KB`
- Dimensions: `2400x3200`
- Title: `Conservatory doors source image`
- Alt Text: `Wide conservatory doors opening into the living space at Restwell`
- Caption: `Source image of the conservatory doors.`
- Description: `High-resolution source image of wide doors connecting the conservatory and living space.`
- Usage: Source-only
- SEO/Performance Notes: Do not serve directly. Use `conservatory-doors-display.webp`.

### `conservatory-doors-display.webp`

- Type: Content image
- Size: `56KB`
- Dimensions: `1080x1440`
- Title: `Conservatory doors into living space`
- Alt Text: `Wide conservatory doors opening into the living space at Restwell`
- Caption: `Wide doors help connect the living room and conservatory.`
- Description: `Optimised display image showing the conservatory doors and living space access at Restwell.`
- Usage: Property gallery, access details
- SEO/Performance Notes: Good display size.

### `int-conservatory-doors.webp`

- Type: Source image
- Size: `233KB`
- Dimensions: `2400x3200`
- Title: `Internal conservatory doors source image`
- Alt Text: `Internal doors opening from the home into the conservatory`
- Caption: `Source image of the internal conservatory doors.`
- Description: `High-resolution source image of the internal doorway between the property and conservatory.`
- Usage: Source-only
- SEO/Performance Notes: Do not serve directly. Use `int-conservatory-doors-display.webp`.

### `int-conservatory-doors-display.webp`

- Type: Content image
- Size: `53KB`
- Dimensions: `1080x1440`
- Title: `Internal doors to conservatory`
- Alt Text: `Internal doors opening from the home into the conservatory`
- Caption: `The conservatory is reached through wide internal glazed doors.`
- Description: `Optimised display image showing internal access from the home into the conservatory.`
- Usage: Property gallery, internal access details
- SEO/Performance Notes: Good display size.

### `conservatory-patio-doors.webp`

- Type: Source image
- Size: `584KB`
- Dimensions: `2400x3200`
- Title: `Conservatory patio doors source image`
- Alt Text: `Patio doors opening from the conservatory toward the garden`
- Caption: `Source image of the conservatory patio doors.`
- Description: `High-resolution source image showing patio doors from the conservatory toward the garden.`
- Usage: Source-only
- SEO/Performance Notes: Do not serve directly. Use `conservatory-patio-doors-display.webp`.

### `conservatory-patio-doors-display.webp`

- Type: Content image
- Size: `98KB`
- Dimensions: `1080x1440`
- Title: `Conservatory patio doors`
- Alt Text: `Patio doors opening from the conservatory toward the garden`
- Caption: `Patio doors open from the conservatory toward the garden.`
- Description: `Optimised display image showing the conservatory patio doors and garden access.`
- Usage: Property gallery, garden access content
- SEO/Performance Notes: Good direct-use version. Use lazy loading below the fold.

### `ext-patio-door.webp`

- Type: Source image
- Size: `665KB`
- Dimensions: `2400x3200`
- Title: `External patio door source image`
- Alt Text: `External patio doors leading from Restwell into the garden`
- Caption: `Source image of the external patio doors.`
- Description: `High-resolution source image showing the external patio doors and garden threshold.`
- Usage: Source-only
- SEO/Performance Notes: Do not serve directly. Use `ext-patio-door-display.webp`.

### `ext-patio-door-display.webp`

- Type: Content image
- Size: `97KB`
- Dimensions: `1000x1334`
- Title: `External patio doors to garden`
- Alt Text: `External patio doors leading from Restwell into the garden`
- Caption: `The patio doors connect the home to the garden area.`
- Description: `Optimised display image showing the external patio doors and garden route at Restwell.`
- Usage: Property gallery, garden access, arrival/access content
- SEO/Performance Notes: Good direct-use version. Use lazy loading below the fold.

## Whitstable And Local Area Images

### `accessible-holiday-whitstable.webp`

- Type: Content image
- Size: `73KB`
- Dimensions: `1067x800`
- Title: `Accessible holiday bungalow in Whitstable`
- Alt Text: `Front exterior of the accessible holiday bungalow in Whitstable`
- Caption: `Restwell is an accessible holiday bungalow near Whitstable and Tankerton.`
- Description: `Exterior image of the Restwell accessible holiday property in Whitstable, showing the front of the bungalow and driveway area.`
- Usage: Homepage, property page, about/overview sections
- SEO/Performance Notes: Good size. Strong property overview image.

### `russell-drive-whitstable.webp`

- Type: Content image
- Size: `69KB`
- Dimensions: `1200x900`
- Title: `Restwell exterior on Russell Drive`
- Alt Text: `White accessible bungalow exterior on Russell Drive in Whitstable`
- Caption: `The Restwell bungalow exterior on Russell Drive, Whitstable.`
- Description: `Exterior image of the white bungalow and driveway at Restwell in Whitstable.`
- Usage: Property page, arrival information, local trust content
- SEO/Performance Notes: Good size.

### `restwell-whitstable-beach-huts.webp`

- Type: Hero/banner image
- Size: `40KB`
- Dimensions: `1000x496`
- Title: `Whitstable beach huts`
- Alt Text: `Colourful beach huts along the Whitstable coast`
- Caption: `Colourful beach huts on the Whitstable seafront.`
- Description: `Wide image of colourful beach huts by the sea near Whitstable, suitable for local area and coastal holiday content.`
- Usage: Hero image, local area page, coastal section
- SEO/Performance Notes: Very lightweight. Good hero option.

### `row-of-colorful-beach-homes-2026-03-25-01-44-35-utc.webp`

- Type: Content image
- Size: `88KB`
- Dimensions: `1500x1000`
- Title: `Colourful beach huts`
- Alt Text: `Row of colourful beach huts near Whitstable`
- Caption: `Colourful beach huts are part of the local coastal character.`
- Description: `Image of a row of colourful beach huts, useful for Whitstable coastal area content.`
- Usage: Whitstable guide, local area page, days out content
- SEO/Performance Notes: Good size. Consider renaming to `colourful-whitstable-beach-huts.webp` if references allow.

### `restwell-whitstable-coastline-panorama.webp`

- Type: Hero/banner image
- Size: `69KB`
- Dimensions: `1920x701`
- Title: `Whitstable coastline panorama`
- Alt Text: `Panoramic view across the Whitstable and Tankerton coastline`
- Caption: `A wide view across the Whitstable and Tankerton coastline.`
- Description: `Panoramic coastal image for hero sections, showing the sea, beach, and Tankerton coastline.`
- Usage: Hero image, area guide, poster/fallback option
- SEO/Performance Notes: Strong wide hero candidate. Do not lazy-load when used above the fold.

### `restwell-whitstable-public-beach-path.webp`

- Type: Hero/banner image
- Size: `80KB`
- Dimensions: `1200x669`
- Title: `Whitstable public beach path`
- Alt Text: `Public beach path along the Whitstable coastline`
- Caption: `A public coastal path follows the beach near Whitstable.`
- Description: `Image of the public path beside the Whitstable coastline, useful for local area and access context.`
- Usage: Whitstable guide, coastal walk sections
- SEO/Performance Notes: Good size.

### `restwell-whitstable-coastal-pathway.webp`

- Type: Hero/banner image
- Size: `130KB`
- Dimensions: `1618x1080`
- Title: `Whitstable coastal pathway`
- Alt Text: `Coastal pathway near Whitstable with sea views`
- Caption: `A coastal pathway near Whitstable with open sea views.`
- Description: `Landscape image of a coastal pathway near Whitstable, useful for local area and gentle days out content.`
- Usage: Area guide, walking routes, nearby coast content
- SEO/Performance Notes: Acceptable for hero/banner use.

### `restwell-whitstable-coastal-walk.webp`

- Type: Hero/banner image
- Size: `121KB`
- Dimensions: `1618x1080`
- Title: `Whitstable coastal walk`
- Alt Text: `People walking along the coastal path near Whitstable`
- Caption: `The coastal path offers sea views near Whitstable and Tankerton.`
- Description: `Landscape image of people walking on a coastal route near Whitstable.`
- Usage: Whitstable guide, local area page, walking content
- SEO/Performance Notes: Acceptable for hero/banner use.

### `restwell-whitstable-beach-relaxation.webp`

- Type: Content image
- Size: `86KB`
- Dimensions: `1000x589`
- Title: `Relaxing on Whitstable beach`
- Alt Text: `Person relaxing in a chair on Whitstable beach`
- Caption: `A quiet moment by the sea on Whitstable beach.`
- Description: `Image of a person seated on the shingle beach by the sea near Whitstable.`
- Usage: Local area page, rest and respite content
- SEO/Performance Notes: Good size.

### `restwell-whitstable-sunset-pier.webp`

- Type: Content image
- Size: `38KB`
- Dimensions: `1000x625`
- Title: `Whitstable sunset pier`
- Alt Text: `Person standing on a Whitstable pier at sunset`
- Caption: `Sunset over the water near Whitstable.`
- Description: `Coastal sunset image showing a person standing on a pier by the sea near Whitstable.`
- Usage: Local area, emotional/respite sections, hero support image
- SEO/Performance Notes: Very lightweight.

### `restwell-whitstable-marina-sunset.webp`

- Type: Hero/banner image
- Size: `133KB`
- Dimensions: `1618x1080`
- Title: `Whitstable marina at sunset`
- Alt Text: `Boats at Whitstable marina during sunset`
- Caption: `Boats resting near Whitstable marina at sunset.`
- Description: `Landscape image of covered boats and marina views near Whitstable at sunset.`
- Usage: Local area guide, days out, coastal character content
- SEO/Performance Notes: Acceptable for hero/banner use.

### `restwell-whitstable-drone-aerial-view.webp`

- Type: Content image
- Size: `84KB`
- Dimensions: `1000x627`
- Title: `Aerial view near Whitstable`
- Alt Text: `Aerial view of homes and green spaces near Whitstable`
- Caption: `An aerial view of the neighbourhood and green spaces near Whitstable.`
- Description: `Aerial image showing the local Whitstable area, nearby homes, roads, and green open spaces.`
- Usage: Area overview, location context
- SEO/Performance Notes: Good size.

### `whitstable-days-out.webp`

- Type: Hero/banner image
- Size: `115KB`
- Dimensions: `1200x798`
- Title: `Whitstable days out`
- Alt Text: `Historic Whitstable street with shops and coastal character`
- Caption: `Whitstable has independent shops, historic streets, and coastal places to visit.`
- Description: `Street scene from Whitstable showing local buildings and independent shopfronts, suitable for days out content.`
- Usage: Whitstable guide, days out content
- SEO/Performance Notes: Good for content or banner use.

### `cobbled-streets-in-rye-2026-03-09-09-20-18-utc.webp`

- Type: Content image
- Size: `121KB`
- Dimensions: `988x667`
- Title: `Cobbled streets in Rye`
- Alt Text: `Cobbled historic street in Rye with flowers and old buildings`
- Caption: `Rye offers historic streets and characterful places for a day out.`
- Description: `Image of a cobbled historic street in Rye with flowers, old buildings, and warm light.`
- Usage: Days out guide, nearby trips content
- SEO/Performance Notes: Slightly above content target but acceptable. Consider renaming to `rye-cobbled-streets.webp`.

### `scenery-of-the-traditional-historical-village-of-l-2026-03-20-02-02-01-utc.webp`

- Type: Content image
- Size: `128KB`
- Dimensions: `1198x800`
- Title: `Historic village lane`
- Alt Text: `Traditional historic village lane with brick buildings and blue sky`
- Caption: `A traditional village street for a slower local day out.`
- Description: `Landscape image of a traditional historic village lane with brick buildings and open blue sky.`
- Usage: Days out guide, nearby villages content
- SEO/Performance Notes: Slightly above content target. Consider renaming to `historic-village-lane.webp`.

### `st-augustines-abbey-in-caterbury-city-england-2026-03-20-01-00-24-utc.webp`

- Type: Content image
- Size: `116KB`
- Dimensions: `890x667`
- Title: `St Augustine's Abbey in Canterbury`
- Alt Text: `St Augustine's Abbey ruins with Canterbury Cathedral in the background`
- Caption: `St Augustine's Abbey and Canterbury make a historic day out from Whitstable.`
- Description: `Image of St Augustine's Abbey ruins in Canterbury with the cathedral visible beyond trees and grass.`
- Usage: Days out guide, Canterbury content
- SEO/Performance Notes: Slightly above content target but acceptable. Consider renaming to `st-augustines-abbey-canterbury.webp`.

## Other Videos

### `a-scenic-dolly-forward-flyover-of-tankerton-beach-2026-01-22-03-01-00-utc.mp4`

- Type: Video
- Size: `2903KB`
- Dimensions: `1920x1080`
- Title: `Tankerton beach scenic flyover`
- Alt Text: Not applicable for video
- Caption: `Scenic flyover footage of Tankerton beach.`
- Description: `Video footage of Tankerton beach for use in background, area guide, or social media contexts.`
- Usage: Optional video content, not primary hero unless compressed further
- SEO/Performance Notes: Use `preload="metadata"` if embedded. Add poster image.

### `restwell-whitstable-beach-drone.mp4`

- Type: Video
- Size: `3371KB`
- Dimensions: `1920x720`
- Title: `Whitstable beach drone video`
- Alt Text: Not applicable for video
- Caption: `Drone footage of the Whitstable and Tankerton coast.`
- Description: `Wide drone video of the coastline near Whitstable and Tankerton.`
- Usage: Optional background or local area video
- SEO/Performance Notes: Acceptable for non-critical video, but do not autoplay below the fold unless there is a strong reason.

### `scenic-whitstable-web.mp4`

- Type: Video
- Size: `2361KB`
- Dimensions: `1920x1080`
- Title: `Scenic Whitstable web video`
- Alt Text: Not applicable for video
- Caption: `Scenic video footage of Whitstable for web use.`
- Description: `Compressed scenic video for Whitstable area content.`
- Usage: Optional local area video
- SEO/Performance Notes: Use a poster image and `preload="metadata"`.

## Fill-In Checklist

For every image uploaded to WordPress:

- Title matches the human-readable subject.
- Alt text is filled unless the image is decorative.
- Caption is only filled if it helps users understand the image.
- Description explains where the image should be used.
- Width and height are preserved through WordPress responsive image output.
- Below-fold images use lazy loading and async decoding.

For every video:

- Title is human-readable.
- Caption/description explain the footage.
- A poster image is chosen.
- Video is not the only meaningful content.
- Background videos are decorative with `aria-hidden="true"`.
- `preload="metadata"` is used unless the video is user-initiated.
