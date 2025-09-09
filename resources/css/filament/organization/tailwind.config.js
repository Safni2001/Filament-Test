const preset = require("../../../../vendor/filament/filament/tailwind.config.preset");

module.exports = {
    presets: [preset],
    content: [
        "./resources/views/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./app/Filament/**/*.php",
        "./vendor/filament/**/*.blade.php",
        "./Modules/**/app/Filament/**/*.php",
    ],
};
