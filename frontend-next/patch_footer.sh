#!/bin/bash

# Extract from HomePageClient: footer
sed -n '/{[/]* ══════════ FOOTER ══════════/,/<\/footer>/p' src/app/HomePageClient.tsx > new_footer.txt

# Replace in SharedLayout.tsx using perl
perl -i -0777 -pe 's/\{\/\* ══════════ FOOTER ══════════ \*\/}.*?<\/footer>/`cat new_footer.txt`/es' src/components/SharedLayout.tsx

