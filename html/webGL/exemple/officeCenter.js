			import * as THREE from '../build/three.module.js';
			import { GLTFLoader } from './jsm/loaders/GLTFLoader.js';

			const loader = new GLTFLoader();
			var pi = Math.PI;

//load gltf object
function office(){
    //Vriable of office and all everythink on it
			var office, woodOffice, computerScreen, keyboard, mouse, mousePad;

				office = new THREE.Group();


				//load woodOffice
				loader.load('models/furnitures/woodOffice/scene.gltf', function ( gltf ) {
					woodOffice = gltf.scene;
					woodOffice.scale.set(1,1,1);
					office.add( woodOffice );
    		});

				//load computerScreen
				loader.load('models/computerScreen/scene.gltf', function ( gltf ) {
					computerScreen = gltf.scene;
					computerScreen.scale.set(8,8,8);
					computerScreen.rotation.y = pi/2;
					computerScreen.position.set(-12, 42,17);
					office.add( computerScreen );
    		});

				//load keyboard
				loader.load('models/keyboard/scene.gltf', function ( gltf ) {
					keyboard = gltf.scene;
					keyboard.scale.set(1,1,1);
					keyboard.rotation.y = pi/2;
					keyboard.position.set(5, 42,15);
					office.add( keyboard );
    		});

				//load mouse
				loader.load('models/mouse/scene.gltf', function ( gltf ) {
					mouse = gltf.scene;
					mouse.scale.set(0.8,0.8,0.8);
					mouse.rotation.y = pi/2;
					mouse.position.set(-5, 43, -20);
					office.add( mouse );
    		});

				//load mousepad
				loader.load('models/mousePad/scene.gltf', function ( gltf ) {
					mousePad = gltf.scene;
					mousePad.scale.set(0.2,0.2,0.2);
					mousePad.rotation.y = pi/2;
					mousePad.position.set(0, 43, -20);
					office.add( mousePad );
    		});

				office.scale.set(8,8,8);
				office.position.set(800,0,600);
				office.rotation.set(0,2*pi/2,0)

				return office;

}

export { office }
