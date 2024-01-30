<?php

add_filter( 'empower_demos_import_query', function ( $query ) {
	$query = array_merge( $query,
		array(
			'theme' => implode( ',', array( 'mesmerize-pro', 'mesmerize-full-screen-pro' ) ),
		)
	);

	return $query;
} );

add_filter( 'extendthemes_ocdi_customizer_templates', function ( $templates ) {
	$templates[] = 'mesmerize-pro';

	return $templates;
} );


add_filter( 'cloudpress\companion\ajax_cp_data', function ( $data, $companion, $filter ) {


	if ( $filter !== "sections" ) {
		return $data;
	}

	/** @var \Mesmerize\Companion $companion */
	$contentSectionsChild = $companion->loadPHPConfig( empower_get_stylesheet_directory() . "/pro/sections/sections.php" );
	$contentSectionsChild = Mesmerize\Companion::filterDefault( $contentSectionsChild );

	if ( isset( $data['sections'] ) && is_array( $data['sections'] ) ) {
		$data['sections'] = array_merge( $data['sections'], $contentSectionsChild );
	}

	foreach ( $data['sections'] as $si => $section ) {
		$data['sections'][ $si ]['content'] = empower_replace_theme_tag( $section['content'] );
	}

	return $data;
}, 21, 3 );
