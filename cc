#!/bin/bash
current_dir=$(dirname "$(realpath $0)")
/opt/php73/bin/php $current_dir/bin/console cache:clear