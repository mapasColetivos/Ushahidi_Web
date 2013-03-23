<?php defined('SYSPATH') OR die('No direct script access');

/**
 * Locations helper
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi - http://github.com/ushahidi/Ushahidi_Web
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
class location_Core {

	/**
	 * Validates submitted location data. This method should be invoked
	 * before the location is saved
	 *
	 * @param  array $post Submitted data
	 * @return Validation on succeed, FALSE otherwise
	 */
	public static function validate(array & $post)
	{
		// Set up validation
		$post = Validation::factory($post)
		    ->pre_filter('trim')
		    ->add_rules('location_name', 'required')
		    ->add_rules('location_description', 'required')
		    ->add_rules('latitude', 'required', 'between[-90,90]')
		    ->add_rules('longitude', 'required', 'between[-180, 180]');

		// Validate only the fields that are filled in
		if ( ! empty($post->location_news))
		{
			foreach ($post->location_news as $key => $url) 
			{
				if ( ! empty($url) AND !(bool) filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED))
				{
					$post->add_error('location_news','url');
				}
			}
		}

		// Validate only the fields that are filled in
		if ( ! empty($post->location_video))
		{
			foreach ($post->location_video as $key => $url) 
			{
				if ( ! empty($url) AND !(bool) filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED))
				{
					$post->add_error('location_video','url');
				}
			}
		}

		// Location photo
		$post->add_rules('location_photo', 'upload::valid', 'upload::type[gif,jpg,png,jpeg]', 'upload::size[2M]');

		return $post->validate();
	}

	/**
	 * Saves a location
	 *
	 * @param  Validation $post
	 * @param  int $incident_id ID of the incident (map) associated with the location
	 * @param  int $user_id ID of the user creating the location 
	 * @return Location_Model
	 */
	public static function save_location($post, $incident_id, $user_id)
	{
		$location = empty($post->id) ? new Location_Model() : ORM::factory('location', $post->id);
		$location->incident_id = $incident_id;
		$location->location_name = $post->location_name;
		$location->location_description = $post->location_description;
		$location->latitude = $post->latitude;
		$location->longitude = $post->longitude;
		$location->incident_legend_id = $post->incident_legend_id;
		if ( ! $location->loaded)
		{
			$location->location_date = date("Y-m-d H:i:s", time());
			$location->user_id = $user_id;
		}
		$location->save();

		return $location;
	}

	/**
	 * Given a location id and an array of media (links, video, images)
	 * saves these media against the location entry
	 *
	 * @param  array $post Data to be saved
	 * @param  int   $location_id ID of the location to add media to
	 * @param  int   $incident_id Incident ID for the media
	 * @param  int   $user_id ID of the user adding the media
	 */
	public static function save_media($post, $location_id, $incident_id, $user_id)
	{
		// a. News
		if (isset($post->location_news))
		{
			// Delete all the news links
			ORM::factory('media')
			    ->where('location_id', $location_id)
			    ->where('incident_id', $incident_id)
			    ->where('media_type', 4)
			    ->delete_all();

			foreach ($post->location_news as $item)
			{
				if ( ! empty($item))
				{
					$news = new Media_Model();
					$news->location_id = $location_id;
					$news->incident_id = $incident_id;
					$news->media_type = 4;		// News
					$news->media_link = $item;
					$news->user_id = $user_id;
					$news->media_date = date("Y-m-d H:i:s",time());
					$news->save();
				}
			}
		}

		// b. Video
		if (isset($post->location_video))
		{
			// Delete all the vide links
			ORM::factory('media')
			    ->where('location_id', $location_id)
			    ->where('incident_id', $incident_id)
			    ->where('media_type', 2)
			    ->delete_all();

			foreach ($post->location_video as $item)
			{
				if ( ! empty($item))
				{
					$video = new Media_Model();
					$video->location_id = $location_id;
					$video->incident_id = $incident_id;
					$video->media_type = 2;		// Video
					$video->media_link = $item;
					$video->media_date = date("Y-m-d H:i:s",time());
					$video->user_id = $user_id;
					$video->save();
				}
			}
		}

		// c. Photos
		if ( ! empty($post->location_photo))
		{
			// Delete all the images
			ORM::factory('media')
			    ->where('location_id', $location_id)
			    ->where('incident_id', $incident_id)
			    ->where('media_type', 1)
			    ->delete_all();

			$filenames = upload::save('location_photo');
			$i = 1;

			foreach ($filenames as $filename)
			{
				$new_filename = $incident_id.'_'.$i.'_'.time();

				$file_type = strrev(substr(strrev($filename),0,4));
				
				// IMAGE SIZES: 800X600, 400X300, 89X59
				// Catch any errors from corrupt image files
				try
				{
					// Large size
					Image::factory($filename)->resize(800,600,Image::AUTO)
						->save(Kohana::config('upload.directory', TRUE).$new_filename.$file_type);

					// Medium size
					Image::factory($filename)->resize(400,300,Image::HEIGHT)
						->save(Kohana::config('upload.directory', TRUE).$new_filename.'_m'.$file_type);

					// Thumbnail
					Image::factory($filename)->resize(89,59,Image::HEIGHT)
						->save(Kohana::config('upload.directory', TRUE).$new_filename.'_t'.$file_type);
				}
				catch (Kohana_Exception $e)
				{
					// Do nothing. Too late to throw errors
				}
				
				// Name the files for the DB
				$media_link = $new_filename.$file_type;
				$media_medium = $new_filename.'_m'.$file_type;
				$media_thumb = $new_filename.'_t'.$file_type;
					
				// Okay, now we have these three different files on the server, now check to see
				//   if we should be dropping them on the CDN
				
				if (Kohana::config("cdn.cdn_store_dynamic_content"))
				{
					$media_link = cdn::upload($media_link);
					$media_medium = cdn::upload($media_medium);
					$media_thumb = cdn::upload($media_thumb);
					
					// We no longer need the files we created on the server. Remove them.
					$local_directory = rtrim(Kohana::config('upload.directory', TRUE), '/').'/';
					@unlink($local_directory.$new_filename.$file_type);
					@unlink($local_directory.$new_filename.'_m'.$file_type);
					@unlink($local_directory.$new_filename.'_t'.$file_type);
				}

				// Remove the temporary file
				@unlink($filename);

				// Save to DB
				$photo = new Media_Model();
				$photo->location_id = $location_id;
				$photo->incident_id = $incident_id;
				$photo->media_type = 1; // Images
				$photo->media_link = $media_link;
				$photo->media_medium = $media_medium;
				$photo->media_thumb = $media_thumb;
				$photo->media_date = date("Y-m-d H:i:s",time());
				$photo->user_id = $user_id;
				$photo->save();
				$i++;
			}
		}
	}

	/**
	 * Saves a new layer
	 *
	 * @param  ORM $user User adding this layer
	 * @param  int $layer_id
	 * @param  array $post
	 *
	 * @return mixed ORM on success, FALSE otherwise
	 */
	public static function save_layer($user, $layer_id, $post)
	{
		$layer = empty($layer_id) ? new Layer_Model() : ORM::factory('layer', $layer_id);

		$layer_data = arr::extract($post, 'layer_name', 'layer_color', 'layer_url');
		$layer_data['layer_file'] = isset($post['layer_file']['name'])? $post['layer_file']['name'] : NULL;

		$layer_file_data = arr::extract($post, 'layer_file');

		// Set up validation for the layer file
		$upload_validate = Validation::factory($layer_file_data)
				->add_rules('layer_file', 'upload::valid','upload::type[kml,kmz]');

		// Validate and save
		if ($layer->validate($layer_data) AND $upload_validate->validate(FALSE))
		{
			$layer->user_id = $user->id;
			$layer->save();

			// Upload the file
			if (($path_info = upload::save("layer_file")) !== FALSE)
			{
				$path_parts = pathinfo($path_info);
				$file_name = $path_parts['filename'];
				$file_ext = $path_parts['extension'];
				$layer_file = $file_name.".".$file_ext;
				$layer_url = '';

				if (strtolower($file_ext) == "kmz")
				{ 
					// This is a KMZ Zip Archive, so extract
					//because there can be more than one file in a KMZ
					$archive = new Pclzip($path_info);
					if (($archive_files = $archive->extract(PCLZIP_OPT_EXTRACT_AS_STRING)) == TRUE)
					{
						foreach ($archive_files as $file)
						{
							$ext_file_name = $file['filename'];
							$archive_file_parts = pathinfo($ext_file_name);
							$file_extension = array_key_exists('extension', $archive_file_parts)
								? $archive_file_parts['extension']
								: '';
							if
							(
								$file_extension == 'kml' AND $ext_file_name AND
								$archive->extract(PCLZIP_OPT_PATH, Kohana::config('upload.directory')) == TRUE
							)
							{ 
								// Okay, so we have an extracted KML - Rename it and delete KMZ file
								rename($path_parts['dirname']."/".$ext_file_name, 
									$path_parts['dirname']."/".$file_name.".kml");
	
								$file_ext = "kml";
								unlink($path_info);
								$layer_file = $file_name.".".$file_ext;
							}
						}
					}

					$layer->layer_url = $layer_url;
					$layer->layer_file = $layer_file;
					$layer->save();
				}
			}
		}
		else
		{
			return FALSE;
		}

		return $layer;
	}
}