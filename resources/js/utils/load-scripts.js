/**
* @@
*/

export function loadScript(src) {
    return new Promise((resolve, reject) => {
      // Check if the script is already loaded
      if (document.querySelector(`script[src="${src}"]`)) {
        resolve();
        return;
      }

      // Create a new script element
      const script = document.createElement('script');
      script.src = src;
      script.async = true;

      script.onload = () => resolve();
      script.onerror = () => reject(new Error(`Failed to load script: ${src}`));

      document.head.appendChild(script);
    });
  }

  export function loadStyle(href) {
    return new Promise((resolve, reject) => {
      // Check if the stylesheet is already loaded
      if (document.querySelector(`link[href="${href}"]`)) {
        resolve();
        return;
      }

      // Create a new link element
      const link = document.createElement('link');
      link.rel = 'stylesheet';
      link.href = href;

      link.onload = () => resolve();
      link.onerror = () => reject(new Error(`Failed to load stylesheet: ${href}`));

      document.head.appendChild(link);
    });
  }
