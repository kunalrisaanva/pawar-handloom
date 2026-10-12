#!/bin/bash

# Extract from HomePageClient: everything between TOP BANNER and end of main-header
sed -n '/{[/]* ══════════ TOP BANNER ══════════/,/<\/header>/p' src/app/HomePageClient.tsx > new_header.txt

# Extract from HomePageClient: mobile menu
sed -n '/{[/]* ══════════ MOBILE MENU ══════════/,/<\/div>/p' src/app/HomePageClient.tsx > new_mobile_menu.txt

# Replace in SharedLayout.tsx using perl
perl -i -0777 -pe 's/\{\/\* ══════════ TOP BANNER ══════════ \*\/}.*?<\/header>/`cat new_header.txt`/es' src/components/SharedLayout.tsx
perl -i -0777 -pe 's/\{\/\* ══════════ MOBILE MENU ══════════ \*\/}.*?<\/div>/`cat new_mobile_menu.txt`/es' src/components/SharedLayout.tsx

